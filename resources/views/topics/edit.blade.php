@extends('layouts.app')

@section('title', 'Edit Topic')

@section('content')
<div class="content">

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const errorMessages = @json($errors->all()).join('\n');

                alert('Unsuccessful Login:\n\n' + errorMessages);
            });
        </script>
    @endif

    <h2>Edit topic</h2>

    <form action="{{ route('topics.editTopic', $topic->id) }}" class="form-stlye" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" id="title" name="topicName" value="{{ $topic->name }}" required>

        <label for="description">Description</label>
        <textarea name="description" required>{{ $topic->description }}</textarea>

        <label for="is_visible">Is Visible</label>
        <select name="is_visible" id="is_visible" required>
            <option value="1" {{ $topic->is_visible ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$topic->is_visible ? 'selected' : '' }}>No</option>
        </select>
        <br>
        <button type="submit" value="Update Topic">Edit Topic</input>
    </form>
</div>
@endsection