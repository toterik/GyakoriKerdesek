<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to ensure the user is authenticated.
 *
 * This middleware checks if the user is authenticated. If the user is logged in,
 * the request is allowed to proceed. If not, the user is redirected to the login
 * page with an alert message.
 */
class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the user is authenticated. If so, it allows the request
     * to proceed; otherwise, it redirects the user to the login page with an alert
     * message indicating that login is required.
     *
     * @param \Illuminate\Http\Request $request The incoming request.
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next The next middleware or request handler.
     * @return \Symfony\Component\HttpFoundation\Response The response from the next middleware or a redirect response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            return $next($request);
        }

        // Redirect to the login page with an alert message if the user is not authenticated
        return redirect()->route('login.form')->with('alert', 'You need to log in to access this page.');
    }
}
