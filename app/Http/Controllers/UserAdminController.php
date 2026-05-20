<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserAdminController extends Controller
{
    /**
     * Display all users
     */
    public function index()
    {
        $users = User::with('role')
            ->latest()
            ->get();

        return view(
            'pages.admin.users.index',
            compact('users')
        );
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        /**
         * Prevent deleting self
         */
        if ($user->id === Auth::id()) {

            return back()->with(
                'error',
                'Kamu tidak bisa menghapus akun sendiri.'
            );

        }

        /**
         * Delete photo
         */
        if ($user->photo) {

            Storage::disk('public')
                ->delete($user->photo);

        }

        /**
         * Delete user
         */
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User berhasil dihapus.'
            );
    }

    /**
     * Edit user
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view(
            'pages.admin.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    /**
    * Update user
    */
    public function update(
        Request $request,
        User $user
    )
    {
        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'role_id' =>
                'required|exists:roles,id',

            'password' =>
                'nullable|min:6',

        ]);

        /**
        * Update data
        */
        $user->name = $validated['name'];

        $user->role_id = $validated['role_id'];

        /**
        * Optional password update
        */
        if (!empty($validated['password'])) {

            $user->password =
                bcrypt($validated['password']);

        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User berhasil diupdate.'
            );
    }
}