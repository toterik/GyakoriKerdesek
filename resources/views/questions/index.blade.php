@extends('layouts.app')

@section('title', 'Questions in: ' . $topicName)

@section('content')
<div class="search-container">
    <h1>Questions in: {{ $topicName }}</h1>

    <form method="GET" class="search" action="{{ route('questions.index', ['topicName' => $topicName]) }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions...">
        <input type="submit" value="Search">
    </form>
</div>

@if($questions->count() > 0)
    @foreach ($questions as $question)
        <ul class="question-ul">
            <li>
                <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
                    {{ $question->title }}
                </a>
                <p>
                    ({{ $question->answers_count }})
                </p>
            </li>
        </ul>
    @endforeach
@else
    <p>No questions found for this topic.</p>
@endif

{{ $questions->links('pagination::bootstrap-5') }}
@endsection