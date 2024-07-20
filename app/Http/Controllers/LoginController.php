<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for handling user authentication (login/logout).
 */
class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * This method returns the view for the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     *
     * This method validates the login credentials, checks if the user is active,
     * and attempts to authenticate the user. If successful, it regenerates the session
     * and redirects the user to their intended destination. Otherwise, it returns
     * back with an error message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Invalid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ]);
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'active' => 'This account is no longer active.',
            ]);
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'error' => 'The password doesn\'t match with the provided email.'
        ]);
    }

    /**
     * Handle the logout request.
     *
     * This method logs out the user, invalidates the session, and regenerates
     * the session token to protect against CSRF attacks. It then redirects
     * the user to the home page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the current session
        $request->session()->invalidate();
        // Regenerate the session token
        $request->session()->regenerateToken();
        return redirect()->to('/'); 
    }
}
