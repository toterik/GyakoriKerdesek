@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1>All users</h1>
    <div class="container">
        <div class = "content">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Is Admin</th>
                        <th>Is Active</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                            <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at ?? '-' }}</td>
                            <td>
                                <form action="{{ route('users.showEditUserForm', ['userId' => $user->id]) }}" method="GET">
                                    @csrf
                                    <input type="image" src="{{ asset('images/edit.png') }}" alt="Edit" class="form-image">
                                </form>
                            </td>
                            <td>
                                @if (Auth::user()->id != $user->id)
                                    <form action="{{ route('users.delete', $user->id) }}"
                                    method="POST" onsubmit="return confirm('Are you sure you want to delete this user ({{$user->username}})?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="image" src="{{ asset('images/x.png') }}" alt="Delete"  class="form-image">
                                    </form>
                                @endif 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
