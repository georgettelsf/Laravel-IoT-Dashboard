<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

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
        // return response()->json(['email' => 'Invalid credentials'], 422);
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