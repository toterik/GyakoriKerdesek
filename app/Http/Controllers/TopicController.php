<?php

namespace App\Http\Controllers;
use App\Models\Topic; // Ensure this matches your actual model namespace and class name
use Illuminate\Routing\Controller;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        print($topics);

        return view('topics', compact('topics'));
    }
}
