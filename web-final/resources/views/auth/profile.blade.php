@extends('_components.template')

@php
    $page_title = 'Profile';
    $enable_footer = true;
@endphp

@section('content')
    <div class="hstack">
        <h2 class="heading">PROFILE</h2>
        <form method="POST" action="{{ route('handleLogout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">LOGOUT</button>
        </form>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('profile.handleEdit') }}" class="container">
        @csrf
        <table>
            <tr>
                <td>Name</td>
                <td>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input type="text" name="password" class="form-control">
                </td>
            </tr>
        </table>
        <div class="button-action">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>

@endsection
