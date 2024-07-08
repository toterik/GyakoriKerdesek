@extends('layouts.app')

@section('title', 'Questions in: ' . $topicName)

@section('content')
    @foreach ($questions as $question)
    <h3>
        <a href="{{ route('questions.show', ['topicName' => $topicName, 'questionId' => $question->id]) }}">
            {{ $question->title }} 
        </a>
    </h3>
    @endforeach
@endsection