@extends('shop::base')

@section('main')
    <div class="container">
        <h1>{{ $product->title }}</h1>

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


        @if(isset($product->related) && count($product->related))
            <div class="well">
                <h2>Related Products</h2>
                @foreach($product->related as $related)
                    <a href="{{ route('product.show', $related->slug) }}">{{$related->title}}</a>
                @endforeach
            </div>
        @endif
        
        <pre>
            {{ $product }}
        </pre>

    </div>
@stop