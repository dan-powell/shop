@extends('shop::base')

@section('main')

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

        </div>
        <div class="col-sm-6">

            <h3>Specifications</h3>
            <ul class="list-group">
                @if(isset($product->weight) && $product->weight != '')
                    <li class="list-group-item">Weight <span class="badge">{{ $product->weight }} kg</span></li>
                @endif
                @if(isset($product->width) && $product->width != '')
                    <li class="list-group-item">Width <span class="badge">{{ $product->width }} cm</span></li>
                @endif
                @if(isset($product->height) && $product->height != '')
                    <li class="list-group-item">Height <span class="badge">{{ $product->height }} cm</span></li>
                @endif
                @if(isset($product->length) && $product->length != '')
                    <li class="list-group-item">Length <span class="badge">{{ $product->length }} cm</span></li>
                @endif
            </ul>


            <form action="{{ route('shop.cart.product.store') }}" method="post">

                {!! csrf_field() !!}

                <input type="hidden" name="product_id" value="{{ $product->id }}"/>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @if(isset($product->quantity) && $product->quantity > 0)
                                In Stock | <span class="badge">{{ $product->quantity }}</span> Available
                            @else
                                Out of Stock
                            @endif
                        </h3>
                    </div>

                    @foreach($product->optionGroups as $optionGroup)
                        @if (isset($optionGroup->options) && count($optionGroup->options))
                            <div class="panel-body">
                                @include('shop::optionGroups.types.' . $optionGroup->type, ['optionGroup' => $optionGroup])
                            </div>
                        @endif
                    @endforeach

                    @foreach($product->personalisations as $personalisation)
                        <div class="panel-body">
                            @include('shop::personalisations.types.' . $personalisation->type, ['personalisation' => $personalisation])
                        </div>
                    @endforeach

                    <div class="panel-body">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="quantity" value="1"/>
                    </div>

                    <div class="panel-footer clearfix">
                        <button class="btn btn-primary pull-right">Add to Cart</button>
                    </div>
                </div>
            </form>

        </div>

    </div>

    @if(isset($product->image_types) && count($product->image_types))
        @include('shop::partials.imageTypes', ['image_types' => $product->image_types])
    @endif


    @if(isset($product->related) && count($product->related))
        <div class="well">
            <h3>Related Products</h3>
            <div class="row">
                @foreach($product->related as $key => $product)

                    <div class="col-sm-6">
                        @include('shop::product.partials.snippet', ['product' => $product])
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