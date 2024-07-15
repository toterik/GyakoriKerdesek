@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    <div class="container">
        <h1>Forgot Your Password?</h1>
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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <button type="submit">Send Password Reset Link</button>
        </form>
    </div>
@endsection
