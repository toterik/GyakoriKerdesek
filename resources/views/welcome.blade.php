@extends('layouts.app')

@section('title', 'Index')

@section('content')
    <div class="container">
        <div class="sidebar">
        <h1>Select a Topic</h1>
            <ul>
                @foreach ($topics as $topic)
                   <div>
                        <a href="{{ route('questions.index', ['topicName' => $topic->name]) }}" title="{{ $topic->description }}">
                            {{ $topic->name }}
                        </a>    
                        @if (Auth::user() != null && Auth::user()->is_admin)
                            <form action="{{ route('topics.delete', [$topic->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                                @csrf
                                @method('DELETE')
                                <input type="image" src="{{ asset('images/x.png') }}" class="form-image" alt="Delete">
                            </form>
                            <form action="{{ route('topics.showEditTopicForm', ['id' => $topic->id]) }}" method="POST">
                                @csrf
                                <input type="image" src="{{ asset('images/edit.png') }}" class="form-image" alt="Edit">
                            </form>
                        @endif
                   </div>
                @endforeach
            </ul>
        </div>
        <div class="content">
            <h1>Most Popular Questions Last Week</h1>
            @foreach ($popularQuestions as $question)
                <p>
                    <a href="{{ route('questions.show', ['topicName' => $question->topic->name, 'questionId' => $question->id]) }}">
                        {{ $question->title }}
                    </a>
                </p>
            @endforeach

            <h1>Questions That Haven't Been Answered</h1>
            @foreach ($randomUnansweredQuestions as $question)
                <p>
                    <a href="{{ route('questions.show', ['topicName' => $question->topic->name, 'questionId' => $question->id]) }}">
                        {{ $question->title }}
                    </a>
                </p>
            @endforeach
        </div>
    </div>
@endsection
