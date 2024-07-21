@extends('layouts.app')

@section('title', 'Questions in: ' . $topicName)

@section('content')
    <div class="search-container">
        <h1>Questions in: {{$topicName}}</h1>

        <form method="GET" class="search" action="{{ route('questions.index', ['topicName' => $topicName]) }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions...">
            <input type="submit" value="Search">
        </form>
    </div>

    @foreach ($questions as $question)
        <h3>
            <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
                {{ $question->title }}
            </a>
        </h3>
    @endforeach

    {{ $questions->links('pagination::bootstrap-5') }}
@endsection