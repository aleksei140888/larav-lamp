@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <h3>{{ $user->name }}</h3>
            <p>Id - {{ $user->id }}</p>
            <p>Email - {{ $user->email }}</p>
            <a href="{{ route('user_posts', ['id' => 1]) }}">User posts</a>
        </div>
    </div>
@endsection