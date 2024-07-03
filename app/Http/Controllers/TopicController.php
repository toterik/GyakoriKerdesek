<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use Illuminate\Routing\Controller;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all()->where("is_visible",1);

        return view('welcome', compact('topics'));
    }
}
