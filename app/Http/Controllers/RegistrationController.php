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
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect to the login form with a success message
        return redirect()->route('login.form')->with('success', 'Registration successful!');
    }
}
