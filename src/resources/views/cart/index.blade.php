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


    @if(isset($cart))

        <div class="row">
            <div class="col-sm-12">

                <h4>All Items</h4>
                <table class="table">
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

                    @foreach($cart->cartProducts as $cartProduct)

                        @include('shop::cart.partials.cartRow', ['cartProduct' => $cartProduct, 'editable' => true, 'images' => true])

                        @if(count($cartProduct->filteredConfigs))

                            <tr class="collapse" id="collapseExample{{ $cartProduct->id }}">
                                <td colspan="6">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Options</th>
                                                <th>Personalisations</th>
                                                <th>Options Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($cartProduct->filteredConfigs as $config)


                                                <tr>
                                                    <td>
                                                        <ul>
                                                            @foreach(json_decode($config->options, true) as $optionGroup)

                                                                <li><strong>{{ $optionGroup['title'] }}</strong>: {{ $optionGroup['option']['label'] }} <span class="badge">{{ $optionGroup['option']['price_modifier'] }}</span></li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach(json_decode($config->personalisations, true) as $personalisation)
                                                                <li><strong>{{ $personalisation['label'] }}</strong>: {{ $personalisation['value'] }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        {{ $config->sub_total }}
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

        <a href="{{ route('shop.order.create') }}" class="btn btn-primary">
            Checkout
        </a>


    @endif



    @if(isset($cart))
        <hr/>

        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Model Array
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($cart->toArray()) }}
            </pre>
        </div>
    @endif


    @if(isset($data))
        <hr/>

        <a class="btn btn-danger" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Data Dump
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($data) }}
            </pre>
        </div>
    @endif

@stop