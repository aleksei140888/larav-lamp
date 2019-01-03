@extends('layouts.app')

@section('content')
@if($post)
  <div class="container">
    <h1>{!! $post->title !!}</h1>
    <hr>
    <p>{!! $post->content !!}</p>
  </div>
@else
404 ошибка
@endif
@endsection