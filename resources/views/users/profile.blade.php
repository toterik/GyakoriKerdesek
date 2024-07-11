@extends('layouts.app')

@section('title', 'Profile')
@section('content')
    <h1>My questions</h1>
    @foreach ($user->questions as $question)
    <h3>
        <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
            {{ $question->title }} 
        </a>
        <form action="{{ route('questions.deleteFromProfile', $question->id) }}"
        method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
            @csrf
            <input type="image" src="{{ asset('images/x.png') }}" alt="Delete"  style="width: 16px; height: 16px;">
        </form>
    </h3>
    @endforeach
@endsection
