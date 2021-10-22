<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->query('email');
        $password = $request->query('password');

        if (!$email || !$password) {
            return response()->json([
                'error' => 'All fields are required',
            ]);
        }

        $user = User::where('email', $email)->where('is_active', true)->with('roles')->first();


        if ($user && Hash::check($password, $user->password)) {
            return response()->json([
                'success' => 'Login successful.',
                'user' => $user,
            ]);
        }
        return response()->json([
            'error' => 'Email or password is invalid',
        ]);
    }

    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $phone = $request->phone;
        // $sponsor_username = $request->sponsor_username ?? null;
        // $club_id = $request->club_id;
        $username = $request->username;

        if (
            !$name ||
            !$email ||
            !$password ||
            !$password_confirmation ||
            // !$club_id ||
            !$phone ||
            !$username
        ) {
            return response()->json([
                'error' => 'All fields are required.',
            ]);
        }

        $user_count = User::where('email', $email)->count();
        if ($user_count > 0) {
            return response()->json([
                'error' => 'Email already taken.',
            ]);
        }

        $user_count = User::where('phone', $phone)->count();
        if ($user_count > 0) {
            return response()->json([
                'error' => 'Phone already taken.',
            ]);
        }

        $user_count = User::where('username', $username)->count();
        if ($user_count > 0) {
            return response()->json([
                'error' => 'Username already taken.',
            ]);
        }

        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            // 'sponsor_username' => $sponsor_username,
            // 'club_id' => $club_id ?? null,
        ])->assignRole('User');
        return response()->json([
            'success' => 'Registration successful.',
            'user' => User::where('email', $email)->with('roles')->first(),
        ]);
    }
}
