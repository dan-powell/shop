@extends('shop::base')

@section('main')
    <h1>{{ $product->title }}</h1>

    @if(isset($product->image_types) && count($product->image_types))
        @foreach($product->image_types as $key => $type)
            <h4>{{ config('shop.image_types.' . $key . '.title') }}</h4>
            <div class="row">
                @foreach($type as $image)
    
                    <div class="col-sm-3">
    
                    <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}" class="img-responsive"/>
    
                    {{ $image->title }}
    
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif


    @if(isset($product->related) && count($product->related))
        <div class="well">
            <h2>Related Products</h2>
            @foreach($product->related as $related)
                <a href="{{ route('shop.product.show', $related->slug) }}">{{$related->title}}</a>
            @endforeach
        </div>
    @endif

    <code>
        {{ $product }}
    </code>
@stop