<!-- resources/views/welcome.blade.php -->
<html>
<head>
    <title>Welcome Page</title>
</head>
<body>
    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->username }}</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Kijelentkezés</button>
        </form>
    @else
        <p>Welcome, stranger</p>
        <a href="{{ route('registration') }}">Regisztráció</a>
        <a href="{{ route('login') }}">Bejelentkezés</a> 
    @endif

    <a href="{{ route('newQuestionShow') }}">Tegyél fel egy új kérdést</a>
    <h1>Select a Topic</h1>
    <ul>
        @foreach ($topics as $topic)
            <li>
                <a href="{{ route('showQuestions', ['topicId' => $topic->id]) }}">
                    {{ $topic->name }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
