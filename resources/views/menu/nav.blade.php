<body>
    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->username }}</p>
        <a href="{{ route('index') }}">Kezdőlap</a> 
        <a href="javascript:void" onclick="document.getElementById('logout-form').submit();">
            Kijelentkezés
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    @else
        <p>Welcome, stranger</p>
        <a href="{{ route('index') }}">Kezdőlap</a> 
        <a href="{{ route('registration.form') }}">Regisztráció</a>
        <a href="{{ route('login.form') }}">Bejelentkezés</a> 
    @endif

    <a href="{{ route('questions.create') }}">Tegyél fel egy új kérdést</a>
</body>