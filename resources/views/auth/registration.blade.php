@extends('layouts.app')

@section('title', 'Registration')

@section('content')
    <div class="container">
        <h1>Register</h1>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="signUp" action="{{ route('signUp') }}" method="POST">
            @csrf
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="passwordConfirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>
@endsection