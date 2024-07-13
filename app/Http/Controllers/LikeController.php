<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Like;

class LikeController
{
    public function vote(Request $request)
    {
        if (Auth::user() == null)
        {
            return redirect(route("login"))->with("error","You need to login first");
        }
        $userId = Auth::user()->id;
        $answerId = $request->answerId;
        $type = $request->vote_type;

        $like = Like::where("user_id", $userId)->where("answer_id", $answerId)->first();
        if ($like) 
        {
            if ($like->type != $type)
            {
                $like->update(['type' => $type]);
            }   
        }   
        else
        {
            Like::create([
                'user_id' => $userId,
                'answer_id' => $answerId,
                'type' => $type,
            ]);
        }
        return back();
    }
}
