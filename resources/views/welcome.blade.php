@extends('layouts.app')

@section('title', 'Index')

@section('content')
<div class="container">
    <div class="sidebar">
        <h1>Select a Topic</h1>
        <ul>
            @foreach ($topics as $topic)
                <li>
                    <a href="{{ route('questions.index', ['topicName' => $topic->name]) }}"
                        title="{{ $topic->description }}">
                        {{ $topic->name }}
                    </a>
                    @if (Auth::check() && Auth::user()->is_admin)
                        <form action="{{ route('topics.delete', [$topic->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this topic?');">
                            @csrf
                            @method('DELETE')
                            <input type="image" src="{{ asset('images/x.png') }}" class="form-image" alt="Delete">
                        </form>
                        <form action="{{ route('topics.showEditTopicForm', ['id' => $topic->id]) }}" method="GET">
                            @csrf
                            <input type="image" src="{{ asset('images/edit.png') }}" class="form-image" alt="Edit">
                        </form>
                        @if ($topic->is_visible)
                            <img src="{{asset('images/visible.png')}}" alt="visible" class="form-image">
                        @else
                            <img src="{{asset('images/not_visible.png')}}" alt="not visible" class="form-image">
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="content">
        <h1>Most Popular Questions Last Week</h1>
        @if($popularQuestions->count() > 0)
            @foreach ($popularQuestions as $question)
                <ul class="question-ul">
                    <li>
                        <a
                            href="{{ route('questions.show', ['topicName' => $question->topic_name, 'questionId' => $question->id]) }}">
                            {{ $question->title }}
                        </a>
                        <p>({{ $question->answers_count }})</p>
                    </li>
                </ul>
            @endforeach
        @else
            <p>No popular questions found for the last week.</p>
        @endif

        <h1>Questions That Haven't Been Answered</h1>
        @if($randomUnansweredQuestions->count() > 0)
            @foreach ($randomUnansweredQuestions as $question)
                <ul class="question-ul">
                    <li>
                        <a
                            href="{{ route('questions.show', ['topicName' => $question->topic->name, 'questionId' => $question->id]) }}">
                            {{ $question->title }}
                        </a>
                    </li>
                </ul>
            @endforeach
        @else
            <p>No unanswered questions found.</p>
        @endif
    </div>
</div>
@endsection