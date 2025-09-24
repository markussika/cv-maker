<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{
    protected const PROVIDERS = ['google', 'github'];

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

        return $this->redirectToGithub($state);
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
                $userData = $this->handleGithubCallback($request);
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

    protected function redirectToGithub(string $state): RedirectResponse
    {
        $config = config('services.github');
        $clientId = $config['client_id'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($redirectUri), 500, 'GitHub OAuth is not configured.');

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => 'read:user user:email',
            'state' => $state,
            'allow_signup' => 'true',
        ]);

        return redirect()->away('https://github.com/login/oauth/authorize?' . $query);
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

    protected function handleGithubCallback(Request $request): array
    {
        $code = (string) $request->query('code', '');
        if ($code === '') {
            abort(400, 'Missing authorisation code.');
        }

        $config = config('services.github');
        $clientId = $config['client_id'] ?? null;
        $clientSecret = $config['client_secret'] ?? null;
        $redirectUri = $config['redirect'] ?? null;

        abort_if(empty($clientId) || empty($clientSecret) || empty($redirectUri), 500, 'GitHub OAuth is not configured.');

        $tokenResponse = Http::asForm()
            ->withHeaders(['Accept' => 'application/json'])
            ->timeout(10)
            ->post('https://github.com/login/oauth/access_token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'state' => $request->query('state'),
            ]);

        if ($tokenResponse->failed()) {
            abort(400, 'Failed to exchange GitHub authorisation code.');
        }

        $accessToken = $tokenResponse->json('access_token');
        if (!$accessToken) {
            abort(400, 'GitHub did not return an access token.');
        }

        $userResponse = Http::withToken($accessToken)
            ->withHeaders(['Accept' => 'application/vnd.github+json'])
            ->timeout(10)
            ->get('https://api.github.com/user');

        if ($userResponse->failed()) {
            abort(400, 'Unable to fetch GitHub profile.');
        }

        $profile = $userResponse->json();

        $email = isset($profile['email']) && $profile['email'] ? strtolower((string) $profile['email']) : null;
        $emailVerified = $email !== null;

        if (!$email) {
            $emailsResponse = Http::withToken($accessToken)
                ->withHeaders(['Accept' => 'application/vnd.github+json'])
                ->timeout(10)
                ->get('https://api.github.com/user/emails');

            if ($emailsResponse->ok()) {
                $emails = $emailsResponse->json();
                if (is_array($emails)) {
                    foreach ($emails as $emailEntry) {
                        if (!is_array($emailEntry) || empty($emailEntry['email'])) {
                            continue;
                        }

                        $entryEmail = strtolower((string) $emailEntry['email']);
                        $isPrimary = ($emailEntry['primary'] ?? false) === true;
                        $isVerified = ($emailEntry['verified'] ?? false) === true;

                        if ($isPrimary && $isVerified) {
                            $email = $entryEmail;
                            $emailVerified = true;
                            break;
                        }

                        if (!$email && $isVerified) {
                            $email = $entryEmail;
                            $emailVerified = true;
                        } elseif (!$email && $isPrimary) {
                            $email = $entryEmail;
                        }
                    }
                }
            }
        }

        $name = $profile['name'] ?? null;
        if (!$name && !empty($profile['login'])) {
            $name = $profile['login'];
        }

        return [
            'id' => $profile['id'] ?? null,
            'email' => $email,
            'name' => $name ? trim((string) $name) : null,
            'avatar' => $profile['avatar_url'] ?? null,
            'email_verified' => $emailVerified,
        ];
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
