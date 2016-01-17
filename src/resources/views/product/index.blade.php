@extends('shop::base')

@section('main')
    <div class="container">
        <h1>Product Index</h1>

        @if(isset($products) && count($products) > 0)
            <div class="well">
                <h2>All Products</h2>
                <div class="row">
                    @foreach($products as $key => $product)
                        <div class="col-md-4">
                            {{--@include('portfolio::partials.thumb', ['project' => $project])--}}

                            <a href="{{ route('product.show', $product->slug) }}">
                                {{ $product->title }}
                            </a>
                        </div>

                        @if($key % 3 == 2)
                            <div class="clearfix visible-md-block visible-lg-block"></div>
                        @endif

                    @endforeach
                </div>
            </div>
        @else
            <p>No Projects found</p>
        @endif

    </div>
@stop