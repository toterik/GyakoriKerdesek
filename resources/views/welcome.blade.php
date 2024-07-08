<!-- resources/views/welcome.blade.php -->
<html>
<head>
    <title>Welcome Page</title>
</head>
<body>
    @include('menu.nav')
    <h1>Select a Topic</h1>
    <ul>
    @foreach ($topics as $topic)
        <li>
            <a href="{{ route('questions.index', ['topicName' => $topic->name]) }}">
                {{ $topic->name }}
            </a>
            @if (Auth::user() != null && Auth::user()->is_admin)
                <form action="{{ route('topic.setVisibilty',['id' => $topic->id]) }}" method="POST">
                    @csrf
                    @if ($topic->is_visible)
                        <input type="image" src="{{ asset('images/visible.png') }}" alt="visible" style="width: 16px; height: 16px;">
                    @else
                        <input type="image" src="{{ asset('images/not_visible.png') }}" alt="not visible" style="width: 16px; height: 16px;">
                    @endif
                </form>
            @endif
        </li>
    @endforeach
    </ul>

</body>
</html>
