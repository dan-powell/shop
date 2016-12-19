@if(isset($item))
    <tr>

        @if(isset($display_product) && $display_product)
            <td>
                {{ $item->product->title }}
            </td>
        @endif

        <td>
            @if(isset($item->options) && $item->options != '')
                <ul class="CartTable-item-options">
                    @foreach($item->options as $option)
                        <li>
                            <strong>{{ $option->title }}: </strong>
                            {{ $option->pivot->value }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </td>
        <td>
            @if(isset($item->extras) && $item->extras != '')
                <ul class="CartTable-item-extras">
                    @foreach($item->extras as $extra)
                        <li><strong>{{ $extra['title'] }}</strong> <span class="badge">{{ $extra['price'] }}</span>

                            @if(isset($extra['options']) && count($extra['options']))
                                <ul class="">
                                    @foreach($extra['options'] as $option)
                                        <li>
                                            <strong>{{ $option['title'] }}: </strong>
                                            {{ $option['value'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </li>
                    @endforeach
                </ul>
            @endif
        </td>

        <td>
            @if(!isset($editable) || $editable)
                <form class="" action="{{ route('shop.cart.item.update', $item->id) }}" method="POST" id="update">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-6">
                            <input type="number" name="quantity" id="quantity" value="{{ $item->quantity }}" class="form-control"/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default btn-xs">Update</button>
                </form>
            @else
                x{{ $item->quantity }}
            @endif
        </td>

        <td>
            {{ $item->price_sub_total_string }}
        </td>
        @if(!isset($editable) || $editable)
            <td>
                <!-- Actions -->
                <form action="{{ route('shop.cart.item.delete', $item->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-danger btn-xs">
                        Remove
                    </button>
                </form>
            </td>
        @endif
    </tr>
@endif