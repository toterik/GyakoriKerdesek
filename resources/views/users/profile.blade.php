@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1>My questions</h1>
    <div class = "container">
        <ul>
            @foreach ($user->questions as $question)
            <div>
                <a href="{{ route('questions.show', ['topicName' => $question->topic->name, 'questionId' => $question->id]) }}">
                    {{ $question->title }} 
                </a>
                <form action="{{ route('questions.deleteFromProfile', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                    @csrf
                    @method('DELETE')
                    <input type="image" src="{{ asset('images/x.png') }}" class = "form-image" alt="Delete">
                </form>            
            </div>
            @endforeach
        </ul>
    </div>
@endsection
