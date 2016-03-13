@extends('shop::front.frontBase')

@section('base')
    <h1>Confirm your order</h1>

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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($cart->cartItems as $item)
                        @include('shop::front.cartItem.excerpt.partials.itemRow', ['item' => $item, 'display_product' => true])
                    @endforeach
                </tbody>

                <tr>
                    <td colspan="3">
                        <p class="text-right"><strong>Shipping</strong></p>
                    </td>
                    <td>
                        {{ $shipping['title'] }}
                    </td>
                    <td>
                        {{ $shipping['price'] }}
                    </td>
                    <td></td>
                </tr>


                <tr>
                    <td colspan="4">
                        <p class="text-right"><strong>Total</strong></p>
                    </td>
                    <td>
                        {{ $total }}
                    </td>
                    <td></td>
                </tr>


            </table>

        </div>
    </div>

    <form action="{{ route('shop.order.confirm') }}" method="POST">

        {!! csrf_field() !!}

        <input type="text" name="id" value="{{ $order->id }}"/>

        <button class="btn btn-primary">
            Confirm
        </button>
    </form>
@stop