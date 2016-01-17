@extends('shop::base')

@section('main')
    <div class="container">
        <h1>{{ $product->title }}</h1>

        {{ $product }}

    </div>
@stop