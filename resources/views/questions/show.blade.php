@extends('layouts.app')

@section('title', 'Question ')

@section('content')
<div id="question">
    <p class="right-align">{{$userName}} {{$question->created_at->format('Y-m-d')}}</p>
    <div class="title-container">
        <h1 id="question_title">{{ $question->title }}</h1>
        @if (Auth::user() != null && (Auth::user()->is_admin || Auth::user()->id == $question->user_id))
            <form action="{{ route('questions.delete', $question->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this question?');" class="delete-form">
                @csrf
                @method('DELETE')
                <input type="image" src="{{ asset('images/x.png') }}" alt="Delete" class="form-image">
            </form>
        @endif
    </div>

    <p class="left-align">{{ $question->body }}</p>
</div>



@if (count($answers) == 0)
    <h2>Be the first one to answer this question!!</h2>
@else
    <ul class="answers-list">
        @foreach ($answers as $answer)
            <li class="answer-item">
                <p class="answer-body">{{ $answer->body }}</p>
                @if (Auth::user() != null && Auth::user()->is_admin)
                    <form action="{{ route('answers.delete', $answer->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this answer?');">
                        @csrf
                        @method('DELETE')
                        <input type="image" src="{{ asset('images/x.png') }}" alt="Delete" class="delete-button">
                    </form>
                @endif
                <p class="answered-by">Answered by: <span class="username">{{ $answer->user->username }}</span></p>
                <form action="{{ route('likes.vote', $answer->id) }}" method="POST" class="vote-form">
                    @csrf
                    <input type="image"
                        src="{{ $answer->user_vote == true ? asset('images/upvoted.png') : asset('images/upvote.png') }}"
                        alt="Upvote" class="vote-up">
                    <input type="hidden" name="voteType" value="1">
                </form>
                <span class="score">{{ $answer->net_score }}</span>
                <form action="{{ route('likes.vote', $answer->id) }}" method="POST" class="vote-form">
                    @csrf
                    <input type="image"
                        src="{{ $answer->user_vote === false ? asset('images/downvoted.png') : asset('images/downvote.png') }}"
                        alt="Downvote" class="vote-down">
                    <input type="hidden" name="voteType" value="0">
                </form>
            </li>
        @endforeach
    </ul>
@endif

{{ $answers->links('pagination::bootstrap-5') }}

@if (Auth::check())
    <form action="{{route('answers.create')}} " class="form-stlye" method="POST">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <textarea name="body" rows="5" cols="50" placeholder="Type your answer here..." required></textarea>
        <div>
            <button type="submit">Submit Answer</button>
        </div>
    </form>
@else
<h3>You need to <a href="{{ route('login') }}">log in</a> to submit an answer.</h3>
@endauth
@endsection