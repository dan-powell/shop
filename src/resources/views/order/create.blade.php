@extends('shop::base')

@section('main')
    <h1>Checkout</h1>

    @if(isset($cart))

        <div class="row">
            <div class="col-sm-12">

                <h4>All Items</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($cart->cartProducts as $cartProduct)
                            @include('shop::cart.partials.cartRow', ['cartProduct' => $cartProduct, 'editable' => false, 'images' => false])
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @endif



    <form action="{{ route('shop.order.store') }}" method="post">

        {!! csrf_field() !!}

        <div class="well">
            <h2>Delivery</h2>
            @if(isset($shipping_types) && count($shipping_types))
                <select name="shipping_type">
                    @foreach($shipping_types as $key => $shipping_type)
                        <option value="{{ $key }}">{{ $shipping_type['title'] }} ({{ $shipping_type['price'] }})</option>
                    @endforeach
                </select>
            @else
                <p>No delivery options available</p>
            @endif
        </div>

        @include('shop::order.forms.personal')

        @include('shop::order.forms.shipping')

        @include('shop::order.forms.billing')

        <div class="form-horizontal">
            <div class="form-group">
                <label for="instructions" class="col-sm-2 control-label">Extra Instructions</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="instructions" rows="5" placeholder="Add any special instructions for us here.">
                    </textarea>
                </div>
            </div>
        </div>

        <button class="btn btn-primary">
            Continue to confirmation
        </button>

    </form>

@stop