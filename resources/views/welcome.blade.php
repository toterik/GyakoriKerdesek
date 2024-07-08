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
                <form action="{{ route('topics.setVisibilty',['id' => $topic->id]) }}" method="POST">
                    @csrf
                    @if ($topic->is_visible)
                        <input type="image" src="{{ asset('images/visible.png') }}" alt="visible" style="width: 16px; height: 16px;">
                    @else
                        <input type="image" src="{{ asset('images/not_visible.png') }}" alt="not visible" style="width: 16px; height: 16px;">
                    @endif
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