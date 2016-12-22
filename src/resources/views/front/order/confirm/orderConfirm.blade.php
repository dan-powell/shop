@extends('shop::front.frontBase')

@section('base')
    <h1>Confirm your order</h1>

    {{ app('cart')->cart }}

    {{route('shop.order.cancel', '3')}}

    <div class="row">
        <div class="col-sm-12">

            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Options</th>
                    <th>Extras</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($order->cart['cartItems'] as $item)
                        @include('shop::front.cartItem.excerpt.partials.itemRow', [
                            'item' => $item,
                            'display_product' => true,
                            'editable' => false
                        ])
                    @endforeach
                </tbody>

                <tr>
                    <td colspan="3">
                        <p class="text-right">Shipping</p>
                    </td>
                    <td>
                        {{ $order->shipping_type['title'] }}
                    </td>
                    <td>
                        <strong>{{ $shipping_price }}</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <p class="text-right">Total</p>
                    </td>
                    <td>
                        <strong>{{ $order->price_total_string }}</strong>
                    </td>
                </tr>

            </table>

        </div>
    </div>


    <a href="{{ route('shop.order.cancel', $order->id) }}" class="btn btn-default pull-right">Cancel</a>

    <form action="{{ route('shop.order.confirm') }}" method="POST">

        {!! csrf_field() !!}

        <input type="hidden" name="id" value="{{ $order->id }}"/>

        <button class="btn btn-primary pull-right">
            Confirm &amp; Pay
        </button>
    </form>
@stop