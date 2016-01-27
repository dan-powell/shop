<tr>

    @if(isset($images) && $images)
        <td>
            <!-- Image -->
            @if(isset($product->image_types['thumb']))
                <img src="{{ url() }}/{{ $product->image_types['thumb'][0]->path }}/{{ $product->image_types['thumb'][0]->filename }}" class="thumbnail img-responsive" style="max-width: 120px;"/>
            @endif
        </td>
    @endif


    <td>
        <!-- Title -->
        <a href="{{ route('shop.product.show', $product->slug) }}">
            {{ $product->title }}
        </a>

    </td>

    <td>
        <!-- Price -->
        {{ $product->price }}
    </td>

    <td>
        <!-- Qty -->
        <span class="badge">x{{ count($product) }}</span>
    </td>

    <td>
        <!-- Sub Total -->
        
    </td>

    @if(isset($editable) && $editable)
        <td>
            <!-- Actions -->
            <form action="{{ route('shop.cart.product.delete', $product->id) }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-danger btn-xs">
                    Remove
                </button>
            </form>

            @if(count($product))
                <a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#collapseExample{{ $product->id }}" aria-expanded="false" aria-controls="collapseExample{{ $product->id }}">
                    View chosen options
                </a>
            @endif

        </td>
    @endif

</tr>