@extends('_components.template')

@php
    $page_title = 'Register';
@endphp

@section('content')
    <form method="POST" action="{{ route('handleRegister') }}" class="auth-form">
        @csrf
        <div class="avatar avatar-lg">
            <i class="fa fa-user-alt"></i>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" name="name" required>
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <input type="text" class="form-control" placeholder="Password" name="password" required>
            <input type="text" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
            <button type="submit" class="btn btn-primary">Register</button>
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
        <p>Have an account? <a href="{{ route('login') }}">Login</a></p>
    </form>
@endsection
