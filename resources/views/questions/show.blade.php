@extends('layouts.app')

@section('title', 'Question ')

@section('content')
    <h1>{{ $question->title }} by {{$userName}} at {{$question->created_at}}</h1>
    @if (Auth::user() != null && (Auth::user()->is_admin || Auth::user()->id == $question->user_id))
        <form action="{{ route('questions.delete', $question->id) }}"
        method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
            @csrf
            <input type="image" src="{{ asset('images/x.png') }}" alt="Delete"  style="width: 16px; height: 16px;">
        </form>
    @endif
    <p>{{ $question->body }}</p>

    @if (count($answers) == 0)
        <h3>Be the first one to answer this question!!</h3>
    @else
    <h2>Answers:</h2>
    <ul>
    @foreach ($answers as $answer)
        <li>
            {{ $answer->body }}
            @if (Auth::user() != null && Auth::user()->is_admin)
                <form action="{{ route('answers.delete', $answer->id) }}"
                method="POST" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                    @csrf
                    <input type="image" src="{{ asset('images/x.png') }}" alt="Delete"  style="width: 16px; height: 16px;">
                </form>
            @endif

            <p><small>Answered by: {{ $answer->user->username }}</small></p>

            <form action="{{ route('likes.vote', $answer->id) }}" method="POST" >
                @csrf
                <input type="image" src="{{ $answer->user_vote == true ? asset('images/upvoted.png') : asset('images/upvote.png') }}"
                        alt="Upvote" style="width: 16px; height: 16px;">
                <input type="hidden" name="vote_type" value="1">
            </form>
            Net score: {{ $answer->net_score }}
            <form action="{{ route('likes.vote', $answer->id) }}" method="POST">
                @csrf
                <input type="image" src="{{ $answer->user_vote === false ? asset('images/downvoted.png') : asset('images/downvote.png') }}"
                        alt="Downvote" style="width: 16px; height: 16px;">
                <input type="hidden" name="vote_type" value="0">
            </form>

        </li>
    @endforeach
    </ul>
    @endif

    {{ $answers->links() }}

    @if (Auth::check())
        <h2>Submit your answer:</h2>
        <form action="{{route('answers.create')}} " method="POST">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <div>
                <textarea name="body" rows="5" cols="50" placeholder="Type your answer here..." required></textarea>
            </div>
            <div>
                <button type="submit">Submit Answer</button>
            </div>
        </form>
    @else
        <h3>You need to <a href="{{ route('login') }}">log in</a> to submit an answer.</h3>
    @endauth
@endsection