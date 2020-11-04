<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        return response()->json(['error' => 'Invalid credentials']);
    }

    public function register(Request $request){
        $request->validate(
            [
                'name'     => 'equired|string',
                'email'    => 'required|string',
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

    public function update(Request $request, $id){

        $user = Device::findOrFail($id);

        $request->validate(
            [
                'name'     => 'equired|string',
                'email'    => 'required|string',
                'password' => 'required|string|confirmed'
            ]
        );

        $user = User::update([
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