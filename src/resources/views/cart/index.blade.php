@extends('shop::base')

@section('main')
    <h1>Cart</h1>

    @if(old('success') && old('success') != null)
        <div class="alert alert-success">
            <p>{{ old('success') }}</p>
        </div>
    @endif

    @if(old('warning') && old('warning') != null)
        <div class="alert alert-warning">
            <p>{{ old('warning') }}</p>
        </div>
    @endif


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

                            @include('shop::cart.partials.cartRow', ['itemGroup' => $itemGroup, 'editable' => true, 'images' => true])

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

                                                    <tr>
                                                        <td>
                                                            @if(isset($item->options) && $item->options != '')
                                                            <ul>
                                                                @foreach($item->options as $option)
                                                                    <li>
                                                                        <strong>{{ $option['title'] }}: </strong>
                                                                        {{ $option['value'] }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($item->extras) && $item->extras != '')
                                                            <ul>
                                                                @foreach($item->extras as $extra)
                                                                    <li><strong>{{ $extra['title'] }}</strong> <span class="badge">{{ $extra['price'] }}</span>


                                                                        @if(isset($extra['options']) && count($extra['options']))
                                                                            <ul>
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
                                                            <form class="" action="{{ route('shop.cart.item.update', $item->id) }}" method="POST">
                                                                {!! csrf_field() !!}
                                                                <input type="hidden" name="_method" value="PUT">
                                                                <div class="form-group form-group-sm">
                                                                    <div class="col-xs-6">
                                                                        <input type="number" name="quantity" id="quantity" value="{{ $item->quantity }}" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-default btn-xs">Update</button>
                                                            </form>
                                                        </td>

                                                        <td>
                                                            {{ $item->sub_total_string }}
                                                        </td>
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
                                                    </tr>


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

        <a href="{{ route('shop.order.create') }}" class="btn btn-primary pull-right">
            Checkout
        </a>

    @endif
@stop