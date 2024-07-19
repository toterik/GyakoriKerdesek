<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to ensure the user is an administrator.
 *
 * This middleware checks if the authenticated user has admin privileges.
 * If the user is an admin, the request is allowed to proceed. Otherwise,
 * the user is redirected to the welcome page with an alert message.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the user is authenticated and has admin privileges.
     * If so, it allows the request to proceed; otherwise, it redirects the user
     * to the welcome page with an alert message.
     *
     * @param \Illuminate\Http\Request $request The incoming request.
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next The next middleware or request handler.
     * @return \Symfony\Component\HttpFoundation\Response The response from the next middleware or a redirect response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has admin privileges
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirect to the welcome page with an alert message if the user is not an admin
        return redirect()->route('welcome')->with('alert', 'You don\'t have the authority to do this!');
    }
}
