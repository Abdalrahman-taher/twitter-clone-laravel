<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get the validated text fields (name, username, bio, location, website)
        $data = $request->validated();

        // Avatar and cover are files, so we save them separately below
        unset($data['avatar'], $data['cover']);

        $request->user()->fill($data);

        // Save the new avatar if the user uploaded one
        if ($request->hasFile('avatar')) {

            // Delete the old avatar so we don't leave unused files behind
            if ($request->user()->avatar) {
                Storage::disk('public')->delete($request->user()->avatar);
            }

            $request->user()->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Save the new cover if the user uploaded one
        if ($request->hasFile('cover')) {

            // Delete the old cover so we don't leave unused files behind
            if ($request->user()->cover) {
                Storage::disk('public')->delete($request->user()->cover);
            }

            $request->user()->cover = $request->file('cover')->store('covers', 'public');
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
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
