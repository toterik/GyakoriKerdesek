@extends('layouts.app')

@section('title', 'Questions in: ' . $topicName)

@section('content')
    <h1>Questions in: {{$topicName}}</h1>
    
    @foreach ($questions as $question)
    <h3>
        <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
            {{ $question->title }} 
        </a>
    </h3>
    @endforeach
    {{ $questions->links('pagination::bootstrap-5') }}
@endsection