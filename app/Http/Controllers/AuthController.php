<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]
        );

        if (Auth::guard()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return response()->json([], 204);
        }

        throw ValidationException::withMessages(['email' => 'Invalid credentials']);
    }

    public function register(Request $request){
        $validatedData = $request->validate(
            [
                'name'     => 'required|string',
                'email'    => 'required|string|unique:users',
                'password' => 'required|string|confirmed'
            ]
        );

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

        return response()->json([], 204);
    }

    public function getProfile(Request $request) {
        return new UserResource(Auth::user());
    }

    public function updateProfile(Request $request){

        $user = Auth::user();
        $validatedData = $request->validate(
            [
                'name'     => 'required|string',
                'email'    => 'required|string',
                'password' => 'string|confirmed',
                'current' => 'string'
            ]
        );

        if (!Auth::guard('web')->once(['email' => $user->email, 'password' => $validatedData['current']])) {
            throw ValidationException::withMessages(['current' => 'Invalid password']);
        }

        $user = $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([], 204);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([], 204);
    }
}