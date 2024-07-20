<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing user profiles and administrative tasks.
 */
class UserController extends Controller
{
    /**
     * Display the profile of a specific user.
     *
     * This method retrieves a user by ID and checks if the authenticated user
     * has access to view the profile. It then retrieves the user's questions and
     * returns the profile view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);

        // Check if the authenticated user has access to view this profile
        if (Auth::user() == null || (Auth::id() != $user->id && !Auth::user()->is_admin)) {
            return redirect(route('index'))->withErrors('You do not have access to this profile.');
        }

        // Retrieve the user's questions along with their topics
        $questions = $user->questions()->with('topic')->get();

        return view('users.profile', compact('user', 'questions'));
    }

    /**
     * List all users for administrative purposes.
     *
     * This method retrieves all users from the database and returns the
     * user list view. Access is restricted to administrators only.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function listUsers()
    {
        // Check if the authenticated user is an admin
        if (Auth::user() == null || !Auth::user()->is_admin) {
            return redirect(route('index'))->withErrors('You do not have access to this function.');
        }

        // Retrieve all users ordered by ID
        $users = User::orderBy('id')->get();

        return view('users.list', compact('users'));
    }

    /**
     * Delete a specific user.
     *
     * This method deletes the user identified by the provided ID and redirects
     * to the user list view with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request)
    {
        // Find the user by ID and delete them
        User::find($request->userId)->delete();

        return redirect(route('users.list'))->with('success', 'User deleted successfully');
    }

    /**
     * Show the form to edit a specific user.
     *
     * This method retrieves the user by ID and returns the view for editing
     * the user's information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showEditUserForm(Request $request)
    {
        // Find the user by ID or fail
        $user = User::findOrFail($request->userId);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user's information.
     *
     * This method validates the incoming request data and updates the user
     * record with the provided information. It then redirects to the user list
     * view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUser(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required|min:3|unique:users',
        ],[
            'email.unique' => 'The email has already been taken.',
            'username.unique' => 'The username has already been taken.',        
        ]);

        $id = $request->userId;
        // Update the user with the provided data
        User::where('id', $id)->update([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'is_admin' => $request->has('is_admin'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('users.list');
    }
}
