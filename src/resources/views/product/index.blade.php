@extends('shop::base')

@section('main')

    <h1>Product Index</h1>

    @if(isset($products) && count($products) > 0)
        <div class="well">
            <h2>All Products</h2>
            <div class="row">
                @foreach($products as $key => $product)
                    <div class="col-sm-6">

                        @include('shop::product.partials.snippet', ['product' => $product])
                    </div>

                    <!-- Every second iteration... -->
                    @if ( ($key+1) % 2 == 0)
                            <!-- Clear the row every 2 items for sm breakpoint -->
                    <div class="visible-sm-block visible-md-block visible-lg-block clearfix"></div>
                    @endif

                @endforeach
            </div>
        </div>
    @else
        <p>No Projects found</p>
    @endif

@stop