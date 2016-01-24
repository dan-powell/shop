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
            <div class="col-sm-8">

                <h4>All Items</h4>
                <ul>
                    @foreach($cart->cartProducts as $product)

                        <li>
                            <a href="{{ route('shop.product.show', $product->product->slug) }}">
                                {{ $product->product->title }}
                            </a>

                            @if(isset($product->product->image_types['thumb']))
                                <img src="{{ url() }}/{{ $product->product->image_types['thumb'][0]->path }}/{{ $product->product->image_types['thumb'][0]->filename }}" class="thumbnail img-responsive" style="max-width: 120px;"/>
                            @endif


                            <ul>
                                <li><strong>Options</strong></li>
                                @foreach($product->cartOptions as $option)
                                    <li>{{ $option->option->optionGroup->title }}: {{ $option->option->label }}</li>
                                @endforeach
                            </ul>

                            <ul>
                                <li><strong>Personalisations</strong></li>
                                @foreach($product->cartPersonalisations as $personalisation)
                                    <li>{{ $personalisation->personalisation->label }}: {{ $personalisation->value }}</li>
                                @endforeach
                            </ul>

                            <form action="{{ route('shop.cart.product.update', $product->id) }}" method="POST">
                                {!! csrf_field() !!}

                                <input type="hidden" name="product_id" value="{{ $product->product->id }}"/>

                                <input type="hidden" name="_method" value="PUT">

                                <a class="btn btn-success" role="button" data-toggle="collapse" href="#collapseExample{{$product->id}}" aria-expanded="false" aria-controls="collapseExample{{$product->id}}">
                                    Edit
                                </a>

                                <div class="collapse" id="collapseExample{{$product->id}}">
                                    <div class="well">


                                        @foreach($product->product->optionGroups as $optionGroup)
                                            @if (isset($optionGroup->options) && count($optionGroup->options))
                                                <div class="panel-body">
                                                    @include('shop::optionGroups.types.' . $optionGroup->type, ['optionGroup' => $optionGroup])
                                                </div>
                                            @endif
                                        @endforeach


                                        @foreach($product->product->personalisations as $personalisation)

                                            <div class="panel-body">
                                                @include('shop::personalisations.types.' . $personalisation->type, ['personalisation' => $personalisation, 'value' => $product->cartPersonalisations->keyBy('personalisation_id')->get($personalisation->id)->value])
                                            </div>
                                        @endforeach


                                        <button class="btn btn-danger">
                                            Update
                                        </button>


                                    </div>
                                </div>
                            </form>

                            <form action="{{ route('shop.cart.product.delete', $product->id) }}" method="POST">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger">
                                    Remove
                                </button>
                            </form>

                        </li>

                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4">

                <h4>Cart Summary</h4>
                <ul>
                    @foreach($cart->groupedProducts as $group)
                        <li>
                            <span class="badge">x{{ count($group) }}</span>
                            <a href="{{ route('shop.product.show', $group[0]->product->slug) }}">{{ $group[0]->product->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

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