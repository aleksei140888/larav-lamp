@extends('layouts.app')


@section('content')
 <form action="/new-post" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="form-group">
    <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name="title" class="form-control" />
  </div>
  <div class="form-group">
    <textarea name='body'class="form-control">{{ old('content') }}</textarea>
  </div>
  <input type="submit" name='store' class="btn btn-success" value = "Publish"/>
</form>
@endsection
