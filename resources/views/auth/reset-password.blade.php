@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="container">
        <h1>Reset Your Password</h1>
        @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Confirm New Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
@endsection
