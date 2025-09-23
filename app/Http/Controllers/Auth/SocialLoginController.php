<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{
    protected const PROVIDERS = ['google', 'apple'];

    public function redirect(Request $request, string $provider): RedirectResponse
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        $state = Str::random(40);
        $request->session()->put($this->stateSessionKey($provider), $state);
        $intent = $request->query('intent');
        $intent = is_string($intent) && in_array($intent, ['login', 'register'], true) ? $intent : 'login';
        $request->session()->put($this->intentSessionKey($provider), $intent);

        if ($provider === 'google') {
            return $this->redirectToGoogle($state);
        }

        return $this->redirectToApple($state);
    }

    public function callback(Request $request, string $provider)
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        $storedState = $request->session()->pull($this->stateSessionKey($provider));
        $intent = $request->session()->pull($this->intentSessionKey($provider), 'login');
        $incomingState = (string) $request->query('state', $request->input('state', ''));
        if (!$storedState || !hash_equals($storedState, $incomingState)) {
            return $this->redirectWithError(__('The sign in attempt could not be verified. Please try again.'), $provider, $intent);
        }

        try {
            if ($provider === 'google') {
                $userData = $this->handleGoogleCallback($request);
            } else {
                $userData = $this->handleAppleCallback($request);
            }
        } catch (Throwable $exception) {
            Log::warning('Social login failed', [
                'provider' => $provider,
                'message' => $exception->getMessage(),
            ]);

            return $this->redirectWithError(__('We could not complete the sign in. Please try again.'), $provider, $intent);
        }

        if (empty($userData['id'])) {
            return $this->redirectWithError(__('We could not fetch your account details from :provider.', ['provider' => ucfirst($provider)]), $provider, $intent);
        }

        $user = $this->findOrCreateUser($provider, $userData);

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }

    protected function redirectToGoogle(string $state): RedirectResponse
    {
        $config = config('services.google');
        $clientId = $config['client_id'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($redirectUri), 500, 'Google OAuth is not configured.');

        $scopes = implode(' ', ['openid', 'profile', 'email']);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => $scopes,
            'state' => $state,
            'access_type' => 'offline',
            'prompt' => 'select_account',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    protected function redirectToApple(string $state): RedirectResponse
    {
        $config = config('services.apple');
        $clientId = $config['client_id'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($redirectUri), 500, 'Apple sign in is not configured.');

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'name email',
            'state' => $state,
            'response_mode' => 'query',
        ]);

        return redirect()->away('https://appleid.apple.com/auth/authorize?' . $query);
    }

    protected function handleGoogleCallback(Request $request): array
    {
        $code = (string) $request->query('code', '');
        if ($code === '') {
            abort(400, 'Missing authorisation code.');
        }

        $config = config('services.google');
        $clientId = $config['client_id'] ?? null;
        $clientSecret = $config['client_secret'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($clientSecret) || empty($redirectUri), 500, 'Google OAuth is not configured.');

        $tokenResponse = Http::asForm()->timeout(10)->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if ($tokenResponse->failed()) {
            abort(400, 'Failed to exchange Google authorisation code.');
        }

        $accessToken = $tokenResponse->json('access_token');
        if (!$accessToken) {
            abort(400, 'Google did not return an access token.');
        }

        $profileResponse = Http::withToken($accessToken)
            ->timeout(10)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($profileResponse->failed()) {
            abort(400, 'Unable to fetch Google profile.');
        }

        $profile = $profileResponse->json();

        return [
            'id' => $profile['sub'] ?? null,
            'email' => $profile['email'] ?? null,
            'name' => $profile['name'] ?? trim(($profile['given_name'] ?? '') . ' ' . ($profile['family_name'] ?? '')),
            'avatar' => $profile['picture'] ?? null,
            'email_verified' => ($profile['email_verified'] ?? false) === true,
        ];
    }

    protected function handleAppleCallback(Request $request): array
    {
        $code = (string) $request->query('code', '');
        if ($code === '') {
            abort(400, 'Missing authorisation code.');
        }

        $config = config('services.apple');
        $clientId = $config['client_id'] ?? null;
        $teamId = $config['team_id'] ?? null;
        $keyId = $config['key_id'] ?? null;
        $privateKey = $config['private_key'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($teamId) || empty($keyId) || empty($privateKey) || empty($redirectUri), 500, 'Apple sign in is not configured.');

        $clientSecret = $this->generateAppleClientSecret($teamId, $clientId, $keyId, $privateKey);

        $tokenResponse = Http::asForm()->timeout(10)->post('https://appleid.apple.com/auth/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
        ]);

        if ($tokenResponse->failed()) {
            abort(400, 'Failed to exchange Apple authorisation code.');
        }

        $idToken = $tokenResponse->json('id_token');
        if (!$idToken) {
            abort(400, 'Apple did not return an ID token.');
        }

        $claims = $this->decodeJwtClaims($idToken);
        if (empty($claims['sub'])) {
            abort(400, 'Apple did not return the expected user information.');
        }

        $userPayload = $request->input('user');
        $nameFromPayload = null;
        if (is_string($userPayload) && $userPayload !== '') {
            try {
                $decoded = json_decode($userPayload, true, 512, JSON_THROW_ON_ERROR);
                $first = Arr::get($decoded, 'name.firstName');
                $last = Arr::get($decoded, 'name.lastName');
                $nameFromPayload = trim(($first ? ucfirst($first) : '') . ' ' . ($last ? ucfirst($last) : ''));
            } catch (Throwable $exception) {
                // ignore JSON errors
            }
        }

        return [
            'id' => $claims['sub'],
            'email' => $claims['email'] ?? null,
            'name' => $nameFromPayload ?: ($claims['email'] ?? 'Apple User'),
            'avatar' => null,
            'email_verified' => ($claims['email_verified'] ?? 'false') === 'true',
        ];
    }

    protected function generateAppleClientSecret(string $teamId, string $clientId, string $keyId, string $privateKey): string
    {
        $header = [
            'alg' => 'ES256',
            'kid' => $keyId,
        ];

        $claims = [
            'iss' => $teamId,
            'iat' => time(),
            'exp' => time() + 300,
            'aud' => 'https://appleid.apple.com',
            'sub' => $clientId,
        ];

        $segments = [
            $this->base64UrlEncode(json_encode($header, JSON_THROW_ON_ERROR)),
            $this->base64UrlEncode(json_encode($claims, JSON_THROW_ON_ERROR)),
        ];

        $privateKey = $this->formatApplePrivateKey($privateKey);
        $signature = '';
        $success = openssl_sign(implode('.', $segments), $signature, $privateKey, OPENSSL_ALGO_SHA256);

        if (!$success) {
            throw new \RuntimeException('Failed to sign Apple client secret.');
        }

        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    protected function formatApplePrivateKey(string $key): string
    {
        $decoded = $key;
        if (Str::contains($decoded, '\\n')) {
            $decoded = str_replace('\\n', "\n", $decoded);
        }

        $decoded = trim($decoded);

        if (!Str::startsWith($decoded, '-----BEGIN PRIVATE KEY-----')) {
            $decoded = "-----BEGIN PRIVATE KEY-----\n" . $decoded;
        }

        if (!Str::endsWith($decoded, '-----END PRIVATE KEY-----')) {
            $decoded .= "\n-----END PRIVATE KEY-----";
        }

        return $decoded;
    }

    protected function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    protected function decodeJwtClaims(string $token): array
    {
        $segments = explode('.', $token);
        if (count($segments) < 2) {
            throw new \RuntimeException('Invalid token provided.');
        }

        $payload = $segments[1];
        $decoded = base64_decode(strtr($payload, '-_', '+/'), true);
        if ($decoded === false) {
            throw new \RuntimeException('Unable to decode token payload.');
        }

        try {
            $claims = json_decode($decoded, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            throw new \RuntimeException('Invalid token payload.');
        }

        return is_array($claims) ? $claims : [];
    }

    protected function findOrCreateUser(string $provider, array $userData): User
    {
        $providerId = (string) $userData['id'];
        $email = isset($userData['email']) ? strtolower((string) $userData['email']) : null;

        $userQuery = User::query()->where('provider_name', $provider)->where('provider_id', $providerId);
        $user = $userQuery->first();

        if (!$user && $email) {
            $user = User::query()->where('email', $email)->first();
        }

        if (!$user) {
            $name = $userData['name'] ?? null;
            if (!$name && $email) {
                $name = Str::before($email, '@');
            }

            $user = User::create([
                'name' => $name ?: ucfirst($provider) . ' User',
                'email' => $email ?: $provider . '+' . Str::random(8) . '@example.com',
                'password' => Str::password(32),
                'provider_name' => $provider,
                'provider_id' => $providerId,
                'avatar_url' => $userData['avatar'] ?? null,
            ]);
        } else {
            $updates = [
                'provider_name' => $provider,
                'provider_id' => $providerId,
            ];

            if (!empty($userData['avatar'])) {
                $updates['avatar_url'] = $userData['avatar'];
            }

            if ($email && $user->email !== $email) {
                $updates['email'] = $email;
            }

            if (!empty($userData['name']) && $user->name !== $userData['name']) {
                $updates['name'] = $userData['name'];
            }

            $user->forceFill($updates)->save();
        }

        if (!empty($userData['email_verified']) && is_null($user->email_verified_at)) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        return $user;
    }

    protected function redirectWithError(string $message, string $provider, string $intent)
    {
        $route = $intent === 'register' ? 'register' : 'login';

        return redirect()->route($route)->with('oauth_error', $message)->with('oauth_provider', $provider);
    }

    protected function stateSessionKey(string $provider): string
    {
        return 'oauth_state_' . $provider;
    }

    protected function intentSessionKey(string $provider): string
    {
        return 'oauth_intent_' . $provider;
    }
}
