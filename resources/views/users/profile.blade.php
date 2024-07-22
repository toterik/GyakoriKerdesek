@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div id="profile-container">
    <h1>My Questions</h1>
    <h3>{{ Auth::user()->username }}</h3>
</div>
<div class="content">
    <!-- Use $questions instead of $user->questions for paginated results -->
    @foreach ($questions as $question)
        <ul class="question-ul">
            <li>
                <a
                    href="{{ route('questions.show', ['topicName' => $question->topic->name, 'questionId' => $question->id]) }}">
                    {{ $question->title }}
                </a>
                <p>
                    ({{$question->answers_count}})
                </p>
                <form action="{{ route('questions.deleteFromProfile', $question->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this question?');">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{ asset('images/x.png') }}" class="form-image" alt="Delete">
                </form>
            </li>
        </ul>
    @endforeach

    <!-- Display pagination controls -->
    {{ $questions->links('pagination::bootstrap-5') }}
</div>
@endsection