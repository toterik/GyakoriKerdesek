@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container">
        <h1>Login</h1>
        @if (session('error'))
            <div>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection