@extends('shop::base')

@section('main')
    <div class="container">
        <h1>{{ $product->title }}</h1>

        {{ $product }}


        @foreach($product->images as $image)
            <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}"/>
        @endforeach


        @if(isset($product->related) && count($product->related))
            <div class="well">
                <h2>Related Products</h2>
                @foreach($product->related as $related)
                    <a href="{{ route('product.show', $related->slug) }}">{{$related->title}}</a>
                @endforeach
            </div>
        @endif

    </div>
@stop