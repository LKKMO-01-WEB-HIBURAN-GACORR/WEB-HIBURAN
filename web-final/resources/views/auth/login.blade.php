@extends('_components.template')

@php
    $page_title = 'Login';
@endphp

@section('content')
    <form method="POST" action="{{ route('handleLogin') }}" class="auth-form">
        @csrf
        <div class="avatar avatar-lg">
            <i class="fa fa-user-alt"></i>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" required>
            <input type="text" class="form-control" placeholder="Password" name="password" required>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <p>Doesn't have an account? <a href="{{ route('register') }}">Register</a></p>
    </form>
@endsection
