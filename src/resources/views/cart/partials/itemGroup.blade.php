<tr>

    @if(isset($images) && $images)
        <td>
            <!-- Image -->
            @if(isset($itemGroup->product->image_types['thumb']))
                <img src="{{ url() }}/{{ $itemGroup->product->image_types['thumb'][0]->path }}/{{ $itemGroup->product->image_types['thumb'][0]->filename }}" class="thumbnail img-responsive" style="max-width: 120px;"/>
            @endif
        </td>
    @endif


    <td>
        <!-- Title -->
        <a href="{{ route('shop.product.show', $itemGroup->product->slug) }}">
            {{ $itemGroup->product->title }}
        </a>

    </td>

    <td>
        <!-- Price -->
        {{ $itemGroup->product->price_string }}
    </td>

    <td>
        <!-- Qty -->
        <span class="badge">x{{ $itemGroup->quantity }}</span>
    </td>

    <td>
        <!-- Sub Total -->
        {{ $itemGroup->sub_total_string }}
    </td>

    @if(isset($editable) && $editable)
        <td>
            <!-- Actions -->
            <form action="{{ route('shop.cart.clearproduct', $itemGroup->product->id) }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <button class="btn btn-danger btn-xs">
                    Remove
                </button>
            </form>

            @if(count($itemGroup->product))
                <a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#collapseExample{{ $itemGroup->product->id }}" aria-expanded="false" aria-controls="collapseExample{{ $itemGroup->product->id }}">
                    View chosen options
                </a>
            @endif

        </td>
    @endif

</tr>