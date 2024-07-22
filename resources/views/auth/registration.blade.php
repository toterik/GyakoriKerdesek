@extends('layouts.app')

@section('title', 'Registration')

@section('content')
<h1>Sign Up</h1>
<div class="container">
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const errorMessages = @json($errors->all()).join('\n');

                alert('Please correct the following errors:\n\n' + errorMessages);
            });
        </script>
    @endif

    <form id="signUp" class="form-container" action="{{ route('signUp') }}" method="POST">
        @csrf
        <label for="username">Username:</label>
        <input type="text" id="asd" name="username" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <label for="passwordConfirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" required>
        <br>
        <button type="submit">Sign Up</button>
    </form>
</div>
@endsection