<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => null, //default dulu, nanti diubah
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'message' => 'User registered successfully',
        //     'data' => $user,
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ], 201);
        return redirect('/login')->with('success', 'Register berhasil');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (! $user || ! Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
    //         ]);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'data' => $user,
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //     ]);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();

        // return response()->json([
        //     'message' => 'Logged out successfully'
        // ]);
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
    public function me(Request $request)
    {
        // Akan mengembalikan data user saat ini beserta organisasinya nanti
        $user = $request->user()->load('userOrganizations.organization', 'userOrganizations.division', 'userOrganizations.role');
        
        return view('pages.profile', [
            'title' => 'Profile',
            'user' => $user
        ]);
    }
}
