@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
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

<div class="container">
    <form method="POST" class="form-stlye" action="{{ route('password.update') }}">
        @csrf
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required>
        <br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="password_confirmation">Confirm New Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br>
        <button type="submit" value="reset">Reset Password</button>
        <input type="hidden" name="token" value="{{ $token }}">
    </form>
</div>
@endsection