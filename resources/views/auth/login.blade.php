@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1>Login</h1>
<div class="container">

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const errorMessages = @json($errors->all()).join('\n');

                alert('Unsuccessful Login:\n\n' + errorMessages);
            });
        </script>
    @endif

    <form method="POST" class="form-container" action="{{ route('login') }}">
        @csrf

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit" value="Login">Login </button>
        <div>
            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
        </div>
    </form>


</div>
@endsection