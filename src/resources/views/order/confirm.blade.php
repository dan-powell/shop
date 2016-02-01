@extends('shop::base')

@section('main')
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
                </tr>
                </thead>
                <tbody>
                    @foreach($cart->cartItems as $item)
                        @include('shop::cart.partials.itemRow', ['item' => $item, 'display_product' => true])
                    @endforeach
                </tbody>
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