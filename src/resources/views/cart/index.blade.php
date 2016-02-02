@extends('shop::base')

@section('main')
    <h1>Cart</h1>

    @include('shop::partials.messages')

    @if(isset($itemsGrouped))

        <div class="row">
            <div class="col-sm-12">

                @if(isset($errors) && count($errors->all()))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h4>All Items</h4>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($itemsGrouped as $itemGroup)

                            @include('shop::cart.partials.itemGroup', ['itemGroup' => $itemGroup, 'editable' => true, 'images' => true])

                            @if(count($itemGroup))

                                <tr class="collapse" id="collapseExample{{ $itemGroup->product->id }}">
                                    <td colspan="6">

                                        <table class="table table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Options</th>
                                                    <th>Extras</th>
                                                    <th>Quantity</th>
                                                    <th>Line Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($itemGroup->cartItems as $item)
                                                    @include('shop::cart.partials.itemRow', ['item' => $item])
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            @endif

                        @endforeach

                        <tr>
                            <td colspan="5">
                                <p class="text-right"><strong>Total</strong></p>
                            </td>

                            <td>
                                {{ $total }}
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('shop.cart.clear') }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="DELETE">
            <button class="btn btn-default pull-right">
                Clear
            </button>
        </form>

        <a href="{{ route('shop.order.create') }}" class="btn btn-primary pull-right">
            Checkout
        </a>

    @endif
@stop