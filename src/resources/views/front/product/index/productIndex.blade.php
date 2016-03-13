@extends('shop::front.frontBase')

@section('base')

    <h1>Product Index</h1>

    @if(isset($products) && count($products) > 0)
        <div class="well">
            <h2>All Products</h2>
            <div class="row">
                @foreach($products as $key => $product)
                    <div class="col-sm-6">

                        @include('shop::front.product.excerpt.productExcerpt', ['product' => $product])
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

    @if(isset($products))
        <hr/>

        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Model Array
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($products->toArray()) }}
            </pre>
        </div>
    @endif

@stop