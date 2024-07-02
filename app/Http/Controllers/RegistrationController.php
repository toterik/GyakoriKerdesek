<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('registration');
    }

    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('register.index')->with('success', 'Registration successful!');
    }
}
