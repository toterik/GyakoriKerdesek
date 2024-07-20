@extends('layouts.app')

@section('title', 'Create Topic')

@section('content')
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const errorMessages = @json($errors->all()).join('\n');

            alert('Couldn\'t create Topic:\n\n' + errorMessages);
        });
    </script>
@endif

<h1>Create topic</h1>

<form action="{{ route('topics.createTopic') }}" class="form-stlye" method="POST">
    @csrf
    <div>
        <label for="name">Name</label>
        <input type="text" name="topicName" required>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" required></textarea>
    </div>

    <div>
        <label for="is_visible">Is Visible</label>
        <select name="is_visible" id="is_visible" class="form-control" required>
            <option value="1" selected>Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <button type="submit" value="Create topic">Create Topic</input>
</form>
@endsection