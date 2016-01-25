<tr>

    @if(isset($images) && $images)
        <td>
            <!-- Image -->
            @if(isset($cartProduct->product->image_types['thumb']))
                <img src="{{ url() }}/{{ $cartProduct->product->image_types['thumb'][0]->path }}/{{ $cartProduct->product->image_types['thumb'][0]->filename }}" class="thumbnail img-responsive" style="max-width: 120px;"/>
            @endif
        </td>
    @endif


    <td>
        <!-- Title -->
        <a href="{{ route('shop.product.show', $cartProduct->product->slug) }}">
            {{ $cartProduct->product->title }}
        </a>

    </td>

    <td>
        <!-- Price -->
        {{ $cartProduct->price }}
    </td>

    <td>
        <!-- Qty -->
        <span class="badge">x{{ count($cartProduct->configs) }}</span>
    </td>

    <td>
        <!-- Sub Total -->
        {{ $cartProduct->sub }}
    </td>

    @if(isset($editable) && $editable)
        <td>
            <!-- Actions -->
            <form action="{{ route('shop.cart.product.delete', $cartProduct->id) }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-danger btn-xs">
                    Remove
                </button>
            </form>

            @if(count($cartProduct->filteredConfigs))
                <a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#collapseExample{{ $cartProduct->id }}" aria-expanded="false" aria-controls="collapseExample{{ $cartProduct->id }}">
                    View chosen options
                </a>
            @endif

        </td>
    @endif

</tr>