<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
class UserController
{public function index(Request $request)
    {
        $user = User::find($request->userId);
        $topicName = $user->questions->map(function($question)
        {
            return $question->topic->name;
        })->unique();
    
        return view('users.profile', compact('user', 'topicName'));
    }
}
