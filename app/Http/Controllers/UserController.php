<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function index(Request $request)
    {
        $user = User::findOrFail($request->userId);

        if (Auth::user() == null || Auth::id() != $user->id && !Auth::user()->is_admin)
        {
            return redirect(route('index'))->withErrors('You do not have access to this profile.');
        }

        $questions = $user->questions()->with('topic')->get();
    
        return view('users.profile', compact('user', 'questions'));
    }
    public function listUsers()
    {
        if (Auth::user() == null || !Auth::user()->is_admin)
        {
            return redirect(route('index'))->withErrors('You do not have access to this function.');
        }
        $users = User::all();
        return view('users.list', compact('users'));
    }
    
    public function deleteUser(Request $request)
    {
        User::find($request->userId)->delete();
        return redirect(route('users.list'))->with('success','User deleted successfully');
    }

    public function showEditUserForm(Request $request)
    {
        $user = User::findOrFail($request->userId);
        return view('users.edit',compact('user'));
    }
    public function editUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|min:3',
        ]);
        $id = $request->userId;

        
       

        User::where('id',$id)->update([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'is_admin' => $request->has('is_admin'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('users.list');
    }
}
