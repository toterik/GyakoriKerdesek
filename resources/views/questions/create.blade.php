@extends('layouts.app')

@section('title', 'Ask new question')

@section('content')

    

    <h2>Submit Your Post</h2>
    <form action="{{ route('questions.store') }}" method="post">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="body">Body:</label><br>
        <textarea id="body" name="body" rows="10" cols="50" required></textarea><br><br>
        <select id="topic" name="topic" required>
            @foreach ($topics as $topic)
                <option value="{{ $topic->name }}"> {{$topic->name}}</option>
            @endforeach
        </select><br><br>
        

        @if (Auth::check())
        <input type="submit" value="Submit">
        <input type="hidden" value="{{Auth::user()->id}}">
        @else
        <input type="submit" value="Submit" disabled> Jelentkezz be először a kérdés feltevéséhez
        @endif
    </form>
@endsection