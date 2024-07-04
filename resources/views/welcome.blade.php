<!-- resources/views/welcome.blade.php -->
<html>
<head>
    <title>Welcome Page</title>
</head>
<body>
    @include('menu.nav');
    <h1>Select a Topic</h1>
    <ul>
        @foreach ($topics as $topic)
            <li>
            <a href="{{ route('questions.index', ['topicName' => $topic->name]) }}">
                    {{ $topic->name }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
