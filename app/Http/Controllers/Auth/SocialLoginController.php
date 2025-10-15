<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // ✅ add
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{
    protected const PROVIDERS = ['google'];

    public function redirect(Request $request, string $provider): RedirectResponse
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        // CSRF-ish state via session (requires web middleware)
        $state = Str::random(40);
        $request->session()->put($this->stateSessionKey($provider), $state);

        $intent = $request->query('intent');
        $intent = is_string($intent) && in_array($intent, ['login', 'register'], true) ? $intent : 'login';
        $request->session()->put($this->intentSessionKey($provider), $intent);

        return $this->redirectToGoogle($request, $state);
    }

    public function callback(Request $request, string $provider)
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        $storedState   = $request->session()->pull($this->stateSessionKey($provider));
        $intent        = $request->session()->pull($this->intentSessionKey($provider), 'login');
        $incomingState = (string) $request->query('state', $request->input('state', ''));

        if (!$storedState || !hash_equals($storedState, $incomingState)) {
            return $this->redirectWithError(__('The sign in attempt could not be verified. Please try again.'), $provider, $intent);
        }

        try {
            $userData = $this->handleGoogleCallback($request);
        } catch (Throwable $exception) {
            Log::warning('Social login failed', [
                'provider' => $provider,
                'message'  => $exception->getMessage(),
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

    protected function redirectToGoogle(Request $request, string $state): RedirectResponse
    {
        $config      = config('services.google');
        $clientId    = $config['client_id'] ?? null;
        $redirectUri = $this->resolveGoogleRedirectUri($request, $config);

        abort_if(empty($clientId) || empty($redirectUri), 500, 'Google OAuth is not configured.');

        $scopes = implode(' ', ['openid', 'profile', 'email']);

        // For web apps, GET callback is expected.
        $query = http_build_query([
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => $scopes,
            'state'         => $state,
            'access_type'   => 'offline',          // keep if you might want refresh_token later
            'prompt'        => 'consent select_account', // better chance to get refresh_token when needed
            // 'include_granted_scopes' => 'true',  // optional
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    protected function handleGoogleCallback(Request $request): array
    {
        $code = (string) $request->query('code', '');
        if ($code === '') {
            // stay consistent: redirect with error instead of aborting to error page
            throw new \RuntimeException('Missing authorisation code.');
        }

        $config       = config('services.google');
        $clientId     = $config['client_id'] ?? null;
        $clientSecret = $config['client_secret'] ?? null;
        $redirectUri  = $this->resolveGoogleRedirectUri($request, $config);

        abort_if(empty($clientId) || empty($clientSecret) || empty($redirectUri), 500, 'Google OAuth is not configured.');

        $tokenResponse = Http::asForm()
            ->timeout(10)
            ->post('https://oauth2.googleapis.com/token', [
                'code'          => $code,
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri'  => $redirectUri,
                'grant_type'    => 'authorization_code',
            ]);

        if ($tokenResponse->failed()) {
            throw new \RuntimeException('Failed to exchange Google authorisation code.');
        }

        $accessToken = $tokenResponse->json('access_token');
        if (!$accessToken) {
            throw new \RuntimeException('Google did not return an access token.');
        }

        $profileResponse = Http::withToken($accessToken)
            ->timeout(10)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($profileResponse->failed()) {
            throw new \RuntimeException('Unable to fetch Google profile.');
        }

        $profile = $profileResponse->json();

        return [
            'id'             => $profile['sub'] ?? null,
            'email'          => $profile['email'] ?? null,
            'name'           => $profile['name'] ?? trim(($profile['given_name'] ?? '') . ' ' . ($profile['family_name'] ?? '')),
            'avatar'         => $profile['picture'] ?? null,
            'email_verified' => ($profile['email_verified'] ?? false) === true,
        ];
    }

    protected function findOrCreateUser(string $provider, array $userData): User
    {
        $providerId = (string) $userData['id'];
        $email      = isset($userData['email']) ? strtolower((string) $userData['email']) : null;

        $user = User::query()
            ->where('provider_name', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if (!$user && $email) {
            $user = User::query()->where('email', $email)->first();
        }

        if (!$user) {
            $name = $userData['name'] ?? null;
            if (!$name && $email) {
                $name = Str::before($email, '@');
            }

            $user = User::create([
                'name'          => $name ?: ucfirst($provider) . ' User',
                'email'         => $email ?: $provider . '+' . Str::random(8) . '@example.com',
                'password'      => Hash::make(Str::random(32)), // ✅ hash it
                'provider_name' => $provider,
                'provider_id'   => $providerId,
                'avatar_url'    => $userData['avatar'] ?? null,
                'email_verified_at' => !empty($userData['email_verified']) ? now() : null,
            ]);
        } else {
            $updates = [
                'provider_name' => $provider,
                'provider_id'   => $providerId,
            ];

            if (!empty($userData['avatar'])) {
                $updates['avatar_url'] = $userData['avatar'];
            }

            if ($email && $user->email !== $email) {
                // Optional: guard against collisions with existing users
                if (!User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
                    $updates['email'] = $email;
                }
            }

            if (!empty($userData['name']) && $user->name !== $userData['name']) {
                $updates['name'] = $userData['name'];
            }

            $user->forceFill($updates)->save();

            if (!empty($userData['email_verified']) && is_null($user->email_verified_at)) {
                $user->forceFill(['email_verified_at' => now()])->save();
            }
        }

        return $user;
    }

    protected function redirectWithError(string $message, string $provider, string $intent)
    {
        $route = $intent === 'register' ? 'register' : 'login';
        return redirect()->route($route)
            ->with('oauth_error', $message)
            ->with('oauth_provider', $provider);
    }

    /**
     * Resolve the redirect URI for Google OAuth ensuring it matches the incoming request host.
     */
    protected function resolveGoogleRedirectUri(Request $request, array $config): ?string
    {
        $redirectUri = $config['redirect'] ?? null;

        if (empty($redirectUri)) {
            return route('oauth.callback', ['provider' => 'google'], absolute: true);
        }

        $redirectUri = trim($redirectUri);

        if (Str::startsWith($redirectUri, '/')) {
            $redirectUri = $request->getSchemeAndHttpHost() . $redirectUri;
        } elseif (!Str::startsWith($redirectUri, ['http://', 'https://'])) {
            $redirectUri = rtrim($request->getSchemeAndHttpHost(), '/') . '/' . ltrim($redirectUri, '/');
        }

        $normalized = preg_replace('#(?<!:)//+#', '/', $redirectUri);

        return is_string($normalized) ? $normalized : $redirectUri;
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
