<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->fill(Arr::except($validated, ['profile_photo', 'remove_profile_photo']));

        $oldAvatar = $user->getOriginal('avatar_url');

        if ($request->hasFile('profile_photo')) {
            $newPath = $request->file('profile_photo')->store('profile-photos', 'public');

            if ($oldAvatar !== $newPath) {
                $this->deleteStoredProfilePhoto($oldAvatar);
            }

            $user->avatar_url = $newPath;
        } elseif ($request->boolean('remove_profile_photo')) {
            $this->deleteStoredProfilePhoto($oldAvatar);
            $user->avatar_url = null;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    protected function deleteStoredProfilePhoto(?string $path): void
    {
        if (! is_string($path) || trim($path) === '') {
            return;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        try {
            Storage::disk('public')->delete($path);
        } catch (\Throwable $e) {
            // Silently ignore cleanup failures.
        }
    }

    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
