<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        if (auth()->user() == null || !auth()->user()->is_admin) 
        {
            $topics = Topic::where('is_visible', true)->orderBy('name', 'asc')->get();
        }
        else
        {
            $topics = Topic::orderBy('name', 'asc')->get();
        }
       

        return view('welcome', compact('topics'));
    }

    
    public function setTopicVisibility(Request $request,)
    {
        $id = $request->id;
        $topic = Topic::find($id);

        if ($topic) 
        {
       
            $topic->is_visible = !$topic->is_visible;
            $topic->save();

            return redirect()->back()->with('success', 'Topic visibility updated successfully!');
        }

        return redirect()->back()->with('error', 'Topic not found.');
    }
}
