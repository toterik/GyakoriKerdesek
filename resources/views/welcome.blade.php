@extends('layouts.app')

@section('title', 'Index')

@section('content')
    <h1>Select a Topic</h1>
    <ul>
    @foreach ($topics as $topic)
        <li>
            <a href="{{ route('questions.index', ['topicName' => $topic->name]) }}" title="{{ $topic->description }}">
                {{ $topic->name }}
            </a>
            @if (Auth::user() != null && Auth::user()->is_admin)
                <form action="{{ route('topics.delete', [$topic->id]) }}"
                    method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                        @csrf
                        <input type="image" src="{{ asset('images/x.png') }}" alt="Delete"  style="width: 16px; height: 16px;">
                    </form>
                <form action="{{ route('topics.showEditTopicForm',['id' => $topic->id]) }}" method="POST">
                    @csrf
                        <input type="image" src="{{ asset('images/edit.png') }}" alt="edit" style="width: 16px; height: 16px;">
                </form>
            @endif
        </li>
    @endforeach
    </ul>

</body>
</html>
@endsection