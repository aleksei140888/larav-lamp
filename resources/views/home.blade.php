@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                            <a href="{{ url('new-post') }}">Add new post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @foreach( $posts as $post )
        <div class="container">
            <div class="col-md-8 col-md-offset-2" style="background-color: #b1b7ba; border-radius: 5px;">
            <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a></h3>
            <p>{{ $post->summary }}</p>
            <p>By <a href="{{}}">{{ $user }}</a></p>
            <article>
                {!! str_limit($post->body, $limit = 1500) !!}
            </article>
            </div>
        </div>
        @endforeach
@endsection
