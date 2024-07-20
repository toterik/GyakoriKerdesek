<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

/**
 * Controller for managing user registration.
 */
class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     *
     * This method returns the view for the user registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.registration');
    }

    /**
     * Handle user registration.
     *
     * This method validates the registration request, creates a new user
     * record in the database, and redirects to the login form with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'username.required' => 'The username is required.',
            'username.unique' => 'The username has already been taken.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'The email address has already been taken.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            ]);

        // Create a new user with the validated data
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login.form')->with('success', 'Registration successful!');
    }
}
