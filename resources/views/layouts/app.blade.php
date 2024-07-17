<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Your Application')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <header>
        <nav>
            @if (Auth::check())
                <a href="{{ route('index') }}">Start Page</a>
                <a href="{{ route('questions.create') }}">Ask A New Question</a>
                <a href="{{ route('users.profile', ['userId' => Auth::user()->id]) }}">Profile</a>

                @if (Auth::user()->is_admin)
                    <a href="{{ route('topics.showCreateForm') }}">Add New Topic</a>
                    <a href="{{ route('users.list') }}">List profiles</a>
                @endif

                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('index') }}">Start Page</a>
                <a href="{{ route('questions.create') }}">Ask A New Question</a>
                <a href="{{ route('registration.form') }}">Registration</a>
                <a href="{{ route('login.form') }}">Login</a>
            @endif
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>