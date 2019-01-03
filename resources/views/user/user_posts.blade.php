@extends('layouts.app')

@section('content')
    <div class="container">All posts on <b>{{$user->name}}</b></div>
    @foreach( $posts as $post )
        <div class="container">
            <div class="col-md-8 col-md-offset-2" style="background-color: #b1b7ba; border-radius: 5px;">
                <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a></h3>
                <p>{{ $post->summary }}</p>
                <article>
                    {!! str_limit($post->body, $limit = 1500) !!}
                </article>
                <a href="{{ url('post/',$post->id).'/edit' }}">Edit dont work</a>
            </div>
        </div>
    @endforeach
@endsection