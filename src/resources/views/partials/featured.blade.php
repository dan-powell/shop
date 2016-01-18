@if(isset($featured) && count($featured))
    <div class="well">
        <h2>Featured</h2>
        <div class="row">
            @foreach($featured as $key => $product)

                <div class="{{ $col_class or 'col-sm-4' }}">
                    @include('shop::product.partials.snippet', ['product' => $product])
                </div>

            @endforeach
        </div>
    </div>
@endif