<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view(
            'pages.profile.edit'
        );
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'email' =>
                'required|email|max:255|unique:users,email,' . $user->id,

            'photo' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'current_password' =>
                'required',

            'password' =>
                'nullable|confirmed|min:6',

        ]);

        /**
         * Check current password
         */
        if (
            !Hash::check(
                $validated['current_password'],
                $user->password
            )
        ) {

            return back()->withErrors([

                'current_password' =>
                    'Password saat ini salah.'

            ]);

        }

        /**
         * Default old photo
         */
        $photoPath = $user->photo;

        /**
         * Remove photo
         */
        if ($request->remove_photo) {

            if ($user->photo) {

                Storage::disk('public')
                    ->delete(
                        $user->photo
                    );

            }

            $photoPath = null;
        }

        /**
         * Upload new photo
         */
        if ($request->hasFile('photo')) {

            if ($user->photo) {

                Storage::disk('public')
                    ->delete(
                        $user->photo
                    );

            }

            $photoPath = $request
                ->file('photo')
                ->store(
                    'users',
                    'public'
                );

        }

        /**
         * Update user
         */
        $user->update([

            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'photo' =>
                $photoPath,

            'password' =>
                !empty($validated['password'])
                    ? bcrypt($validated['password'])
                    : $user->password,

        ]);

        return redirect()
            ->route('organizations.index')
            ->with(
                'success',
                'Profile berhasil diperbarui.'
            );
    }
}