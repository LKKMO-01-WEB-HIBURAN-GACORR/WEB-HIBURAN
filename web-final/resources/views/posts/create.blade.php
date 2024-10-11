@extends('_components.template')

@php
    $page_title = 'Create Post';
    $enable_footer = true;
@endphp

@section('content')
    @include('_components.header')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2 class="heading">CREATE POST</h2>
    <form method="POST" enctype="multipart/form-data" action="{{ route('posts.handleCreate') }}">
        @csrf
        <table>
            <tr>
                <td>Title</td>
                <td>
                    <input type="text" name="title" class="form-control" required>
                </td>
            </tr>
            <tr>
                <td>Image</td>
                <td>
                    <input type="file" name="image" class="form-control" required>
                </td>
            </tr>
            <tr>
                <td>Content</td>
                <td>
                    <textarea rows="10" name="content" class="form-control" required></textarea>
                </td>
            </tr>
        </table>
        <div class="button-action">
            <a class="btn btn-primary" href="{{ route('posts.list') }}">Back</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
