@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<h1>Forgot Your Password?</h1>
<div class="container">

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

    <form method="POST" class="form-stlye" action="{{ route('password.email') }}">
        @csrf

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        <br>
        <button type="submit">Send Password Reset Link</button>
    </form>
</div>
@endsection