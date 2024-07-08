@extends('layouts.app')

@section('title', 'Edit Topic')

@section('content')
    <h1>Edit topic</h1>

    <form action="{{ route('topics.editTopic', $topic->id) }}" method="POST">
        @csrf

        <div >
            <label for="name">Name</label>
            <input type="text" name="topicName" value="{{ $topic->name }}" required>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" required>{{ $topic->description }}</textarea>
        </div>

        <div>
            <label for="is_visible">Is Visible</label>
            <select name="is_visible" id="is_visible" class="form-control" required>
                <option value="1" {{ $topic->is_visible ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$topic->is_visible ? 'selected' : '' }}>No</option>
            </select>
        </div>
        
        <button type="submit">Update topic</button>
    </form>  

@endsection