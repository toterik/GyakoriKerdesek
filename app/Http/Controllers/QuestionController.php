<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Like;
use App\Models\Question;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing questions and their associated actions.
 */
class QuestionController extends Controller
{
    /**
     * Display a list of questions associated with a specific topic.
     *
     * This method retrieves all questions related to a given topic and 
     * returns them to the view for display.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showQuestionsByTopic(Request $request)
    {
        // Find the topic by name
        $topic = Topic::where('name', $request->topicName)->first();

        if (!$topic) {
            return redirect()->back()->with('error', 'Topic not found.');
        }

        // Get the search term if it exists
        $searchTerm = $request->input('search');

        // Get questions related to the topic, optionally filtering by the search term
        $questionsQuery = Question::where('topic_id', $topic->id)
            ->withCount('answers'); // Add answer count to the query

        if ($searchTerm) {
            // Validate search term if it exists
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);
            $questionsQuery->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        // Paginate the results
        $questions = $questionsQuery->paginate(20);

        $topicName = $request->topicName;

        return view('questions.index', compact('questions', 'topicName', 'searchTerm'));
    }



    /**
     * Show the form to create a new question.
     *
     * This method returns the view for the question creation form, 
     * including a list of visible topics.
     *
     * @return \Illuminate\View\View
     */
    public function showQuestionCreationForm()
    {
        // Get all visible topics
        $topics = Topic::where('is_visible', true)->get();

        return view('questions.create', compact('topics'));
    }

    /**
     * Store a newly created question in the database.
     *
     * This method validates the request, finds the topic by name, 
     * and creates a new question. It then redirects to the newly created
     * question's page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createNewQuestion(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'topic' => 'required|string',
            'title' => 'required|string|max:40|unique:questions,title',
            'body' => 'required|string|max:1000',
        ], [
            'title.max' => 'The title may not be greater than 40 characters.',
            'title.unique' => 'There\'s a question already with this title!',
            'body.max' => 'The question can\'t be longer than 1000 characters.',
        ]);

        // Find the topic ID by topic name
        $topicId = Topic::where('name', $request->topic)->value('id');
        // Get the authenticated user's ID
        $userId = Auth::id();

        $title = $request->title;
        $body = $request->body;

        // Create a new question
        $question = Question::create([
            'user_id' => $userId,
            'topic_id' => $topicId,
            'title' => $title,
            'body' => $body,
        ]);


        return redirect()->route('questions.show', [
            'topicName' => $request->topic,
            'questionId' => $question->id
        ]);
    }

    /**
     * Display a specific question and its answers.
     *
     * This method retrieves a question, its answers, and their associated
     * likes. It also calculates the net score of each answer and 
     * determines the user's vote if logged in. Returns the view with 
     * question details and answers.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        // Find the question by ID
        $question = Question::findOrFail($request->questionId);
        // Get the username of the user who asked the question
        $userName = User::find($question->user_id)->username;

        // Get answers for the question with additional information
        $answers = Answer::where('question_id', $request->questionId)
            ->with('user')
            ->withCount([
                'likes as upvotes_count' => function ($query) {
                    $query->where('type', true);
                },
                'likes as downvotes_count' => function ($query) {
                    $query->where('type', false);
                }
            ])
            ->paginate(10);

        // Get the logged-in user
        $loggedInUser = Auth::user();

        // Calculate net score and user vote for each answer
        foreach ($answers as $answer) {
            $answer->net_score = $answer->upvotes_count - $answer->downvotes_count;

            if ($loggedInUser) {
                $vote = $answer->likes()->where('user_id', $loggedInUser->id)->first();

                $answer->user_vote = $vote ? $vote->type : null;
            } else {
                $answer->user_vote = null;
            }
        }

        // Return the view with the question and answers
        return view('questions.show', compact('question', 'answers', 'userName'));
    }

    /**
     * Delete a specific question.
     *
     * This method deletes the question identified by the provided ID
     * and redirects to the list of questions for the topic from which 
     * the question was deleted.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteQuestion(Request $request)
    {
        // Find the question by ID
        $question = Question::findOrFail($request->questionId);
        // Get the topic name for redirection
        $topicName = $question->topic->name;
        // Delete the question
        $question->delete();

        return redirect()->route('questions.index', ['topicName' => $topicName])->with('success', 'Question deleted successfully!');
    }

    /**
     * Delete a question from the user's profile.
     *
     * This method deletes the question identified by the provided ID
     * and redirects the user to their profile page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFromProfile(Request $request)
    {
        // Find and delete the question by ID
        Question::findOrFail($request->questionId)->delete();

        return redirect()->route('users.profile', ['userId' => Auth::id()]);
    }
}
