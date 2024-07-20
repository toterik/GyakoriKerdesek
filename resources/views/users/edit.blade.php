@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const errorMessages = @json($errors->all()).join('\n');

            alert('Couldn\'t edit the profile:\n\n' + errorMessages);
        });
    </script>
@endif

<h1>Edit Profile</h1>

<form action="{{ route('users.editUser', $user->id) }}" class = "form-stlye" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label for="is_active">Profile Active:</label>
        <input type="checkbox" id="is_active" name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
    </div>
    <div>
        <label for="is_admin">Admin:</label>
        <input type="checkbox" id="is_admin" name="is_admin" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
    </div>
    <input type="hidden" name="userId" value="{{ $user->id }}">
    <button type="submit" value="Update Profile">Edit Profile</input>
</form>
@endsection
