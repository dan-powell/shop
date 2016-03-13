@if(isset($featured) && count($featured))
    <div class="well">
        <h2>Featured Products</h2>
        <div class="row">
            @foreach($featured as $key => $product)

                <div class="{{ $col_class or 'col-sm-6' }}">
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
@endif