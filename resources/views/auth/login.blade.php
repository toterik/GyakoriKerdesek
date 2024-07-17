@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1>Login</h1>
<div class="container">

    @if (session('error'))
        <div>
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <form method="POST" class="form-stlye" action="{{ route('login') }}">
        @csrf

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" value="Login">Bejelentkezés </button>
        <div>
            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
        </div>
    </form>


</div>
@endsection