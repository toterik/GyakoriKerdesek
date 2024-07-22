<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Question;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Controller for managing topics and related operations.
 */
class TopicController extends Controller
{
    /**
     * Display the homepage with topics and popular questions.
     *
     * This method retrieves a list of topics based on user permissions, 
     * as well as popular questions from the last week and random unanswered questions.
     * It then returns the data to the homepage view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if the user is an admin to show all topics or only visible ones
        if ($user && $user->is_admin) {
            $topics = Topic::orderBy('name', 'asc')->get();
        } else {
            $topics = Topic::where('is_visible', true)->orderBy('name', 'asc')->get();
        }
        
        // Get the current date and one week ago for filtering popular questions
        $now = Carbon::now();
        $oneWeekAgo = $now->subWeek();
    
        // Retrieve popular questions with answers created in the last week
        $popularQuestions = DB::table('questions')
            ->select('questions.*', 'topics.name as topic_name', DB::raw('COUNT(answers.id) as answers_count'))
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->join('topics', 'questions.topic_id', '=', 'topics.id')
            ->where('questions.created_at', '>=', $oneWeekAgo)
            ->groupBy('questions.id', 'topics.name')
            ->havingRaw('COUNT(answers.id) > 0')
            ->orderByRaw('COUNT(answers.id) DESC')
            ->limit(10)
            ->get();

        
        // Retrieve random unanswered questions
        $randomUnansweredQuestions = Question::with('topic')
            ->whereDoesntHave('answers')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('welcome', compact('topics', 'popularQuestions', 'randomUnansweredQuestions'));
    }

    /**
     * Show the form to edit a specific topic.
     *
     * This method retrieves the topic by its ID and returns the edit form view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function showEditTopicForm(Request $request)
    {   
        // Find the topic by ID or fail
        $topic = Topic::findOrFail($request->id);

        return view('topics.edit', compact('topic'));
    }

    /**
     * Update the specified topic in the database.
     *
     * This method validates the request data and updates the topic record
     * with the provided information. It then redirects to the homepage with
     * a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editTopic(Request $request)
    {
        // Validate the incoming request data
        $request->validate(
            [
                'topicName' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_visible' => 'required|boolean'
            ]
        );        

        // Update the topic with the provided data
        Topic::where('id', $request->id)->update([
            'name' => $request->topicName,
            'description' => $request->description,
            'is_visible' => $request->is_visible
        ]);

        return redirect()->route('index')->with('success', 'Topic updated successfully.');
    }

    /**
     * Create a new topic.
     *
     * This method validates the request data and creates a new topic record
     * in the database. It then redirects to the homepage with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createTopic(Request $request)
    {
        // Validate the incoming request data
        $request->validate(
            [
                'topicName' => 'required|string|max:255|unique:topics,name',
                'description' => 'nullable|string',
                'is_visible' => 'required|boolean'
            ],
            [
                'topicName.unique' => 'This topic name is already taken',
            ]
        ); 

        // Create a new topic with the provided data
        Topic::create([
            'name' => $request->topicName,
            'description' => $request->description,
            'is_visible' => $request->is_visible
        ]);

        return redirect()->route('index')->with('success', 'Topic created successfully.');
    }

    /**
     * Show the form to create a new topic.
     *
     * This method returns the view for the topic creation form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        return view('topics.create');
    }

    /**
     * Delete a specific topic.
     *
     * This method deletes the topic identified by the provided ID
     * and redirects to the homepage with a success message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTopic(Request $request)
    {
        // Find the topic by ID or fail
        $topic = Topic::findOrFail($request->id);
        // Delete the topic
        $topic->delete();

        return redirect()->route('index')->with('success', 'Topic deleted successfully.');
    }
}
