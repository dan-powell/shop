@extends('shop::front.frontBase')

@section('base')

    @if(isset($product->image_types['hero']))
        <div class="jumbotron" style="background-image: url('{{ url() }}/{{ $product->image_types['hero'][0]->path }}/{{ $product->image_types['hero'][0]->filename }}'); background-size: cover;">
            <h1>{{ $product->title }}</h1>
        </div>
    @else
        <h1>{{ $product->title }}</h1>
    @endif


    <div class="row">
        <div class="col-sm-6">

            @if(isset($product->description) && $product->description != '')
                <hr/>
                    {!! Markdown::parse($product->description) !!}
                <hr/>
            @endif

            @if($product->hasSpecifications)
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Specifications</div>


                    <!-- List group -->
                    <ul class="list-group">
                        @if(isset($product->weight) && $product->weight != '')
                            <li class="list-group-item">Weight <span class="badge">{{ $product->weight_string }}</span></li>
                        @endif
                        @if(isset($product->width) && $product->width != '')
                            <li class="list-group-item">Width <span class="badge">{{ $product->width_string }}</span></li>
                        @endif
                        @if(isset($product->height) && $product->height != '')
                            <li class="list-group-item">Height <span class="badge">{{ $product->height_string }}</span></li>
                        @endif
                        @if(isset($product->length) && $product->length != '')
                            <li class="list-group-item">Length <span class="badge">{{ $product->length_string }}</span></li>
                        @endif
                    </ul>
                </div>
            @endif


        </div>
        <div class="col-sm-6">

            <form action="{{ route('shop.cart.item.store') }}" method="post" id="addToCart">

                {!! csrf_field() !!}

                <input type="hidden" name="product_id" value="{{ $product->id }}"/>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>
                                @if($product->isOnOffer)
                                    <s>{{ $product->price_string }}</s>
                                    <span class="label label-primary">Now {{ $product->price_offer_string }}</span>
                                    <span class="label label-danger">Save {{ $product->price_offer_difference_string }}!</span>
                                @else
                                    {{ $product->price_string }}
                                @endif
                            </strong>

                            <h6>
                                @if($product->isInStock)
                                    In Stock, <span class="badge">{{ $product->stock }}</span> Available
                                @elseif($product->allow_negative_stock)
                                    Available
                                @else
                                    Out of Stock
                                @endif
                            </h6>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(isset($product->options) && count($product->options))
                            <h4><strong>Options</strong></h4>
                            @foreach($product->options as $option)
                                @include('shop::front.option.types.' . config('shop.option_types.' . $option->type . '.view'), ['option' => $option])
                            @endforeach
                        @endif

                        @if(isset($product->extras) && count($product->extras))
                            <h4><strong>Extras</strong></h4>
                            @foreach($product->extras as $extra)

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="extra[{{ $extra->id }}]" id="extra{{ $extra->id }}" class="js-extra-toggle" data-toggle-target=".js-extra-{{$extra->id}}" @if(old('extra.' . $extra->id))checked @endif"/>
                                        {{ $extra->title}}
                                    </label>
                                </div>

                                <div class="extras js-extra-{{$extra->id}}">
                                    @foreach($extra->options as $option)
                                        @include('shop::front.option.types.' . config('shop.option_types.' . $option->type . '.view'), ['option' => $option])
                                    @endforeach
                                </div>

                            @endforeach
                        @endif
                    </div>

                    <div class="panel-body">
                        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                            <label for="quantity" class="control-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                @if(old('quantity'))
                                    value="{{ old('quantity') }}"
                                @else
                                   value="1"
                                @endif
                            />
                            {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="panel-footer clearfix">
                        @if(!$product->isInStock)
                            <button class="btn btn-disabled pull-right" disabled>Out of Stock</button>
                        @elseif(!$product->isAvailable)
                            <button class="btn btn-disabled pull-right" disabled>Currently unavailable</button>
                        @else
                            <button class="btn btn-primary pull-right">Add to Cart</button>
                        @endif
                    </div>
                </div>
            </form>

        </div>

    </div>

    @if(isset($product->image_types) && count($product->image_types))
        @include('shop::front.image.types.imageTypes', ['image_types' => $product->image_types])
    @endif


    @if(isset($product->related) && count($product->related))
        <div class="well">
            <h3>Related Products</h3>
            <div class="row">
                @foreach($product->related as $key => $product)

                    <div class="col-sm-6">
                        @include('shop::front.product.excerpt.productExcerpt', ['product' => $product])
                    </div>

                @endforeach
            </div>
        </div>
    @endif


    @if(isset($product))
        <hr/>

        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Model Array
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($product->toArray()) }}
            </pre>
        </div>
    @endif
@stop