@extends('shop::base')

@section('main')
    <div class="container">
        <h1>{{ $category->title }}</h1>

        {{ $category }}

    </div>
@stop