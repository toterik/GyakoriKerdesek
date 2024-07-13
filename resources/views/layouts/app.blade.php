<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Your Application')</title>
</head>
<body>
    <header>
        <nav>
            @if (Auth::check())
                <p>Welcome, {{ Auth::user()->username }}</p>
                <a href="{{ route('index') }}">Kezdőlap</a>
                <a href="{{ route('questions.create') }}">Tegyél fel egy új kérdést</a> 
                <a href="{{ route('users.profile', ['userId' => Auth::user()->id]) }}">Profile</a>

                @if (Auth::user()->is_admin)
                    <a href="{{ route('topics.showCreateForm') }}">Add New Topic</a>
                    <a href="{{ route('users.list') }}">List profiles</a>
                @endif

                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">Kijelentkezés</a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <p>Welcome, stranger</p>
                <a href="{{ route('index') }}">Kezdőlap</a>
                <a href="{{ route('questions.create') }}">Tegyél fel egy új kérdést</a> 
                <a href="{{ route('registration.form') }}">Regisztráció</a>
                <a href="{{ route('login.form') }}">Bejelentkezés</a>
            @endif
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
