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
                        <tr>


                            <td>
                                <!-- Image -->
                                @if(isset($cartProduct->product->image_types['thumb']))
                                    <img src="{{ url() }}/{{ $cartProduct->product->image_types['thumb'][0]->path }}/{{ $cartProduct->product->image_types['thumb'][0]->filename }}" class="thumbnail img-responsive" style="max-width: 120px;"/>
                                @endif
                            </td>


                            <td>
                                <!-- Title -->
                                <a href="{{ route('shop.product.show', $cartProduct->product->slug) }}">
                                    {{ $cartProduct->product->title }}
                                </a>

                            </td>



                            <td>
                                <!-- Price -->
                            </td>

                            <td>
                                <!-- Qty -->
                                <span class="badge">x{{ count($cartProduct->configs) }}</span>
                            </td>

                            <td>
                                <!-- Sub Total -->
                            </td>

                            <td>
                                <!-- Actions -->
                                <form action="{{ route('shop.cart.product.delete', $cartProduct->id) }}" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-xs">
                                        Remove
                                    </button>
                                </form>

                                <a class="btn btn-primary btn-xs" role="button" data-toggle="collapse" href="#collapseExample{{ $cartProduct->id }}" aria-expanded="false" aria-controls="collapseExample{{ $cartProduct->id }}">
                                    View chosen options
                                </a>

                            </td>

                        </tr>

                        @if(count($cartProduct->filteredConfigs))

                            <tr class="collapse" id="collapseExample{{ $cartProduct->id }}">
                                <td colspan="6">

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Options</th>
                                                <th>Modifier</th>
                                                <th>Personalisations</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($cartProduct->filteredConfigs as $config)


                                                    <tr>
                                                        <td>
                                                            <ul>
                                                                @foreach(json_decode($config->options, true) as $optionGroup)

                                                                    <li><strong>{{ $optionGroup['title'] }}</strong>: {{ $optionGroup['option']['label'] }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <!-- Modifier -->
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @foreach(json_decode($config->personalisations, true) as $personalisation)
                                                                    <li><strong>{{ $personalisation['label'] }}</strong>: {{ $personalisation['value'] }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>


                                            @endforeach


                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        @endif

                    @endforeach



                    </tbody>
                </table>
            </div>
        </div>


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