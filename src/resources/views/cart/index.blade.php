@extends('shop::base')

@section('main')
    <h1>Cart</h1>

    @if(isset($cart))

        <h4>All Items</h4>
        <ul>
            @foreach($cart->products as $product)

                <li>
                    {{ $product->product->title }}
                
                    <ul>
                        @foreach($product->options as $option)
                            <li>{{ $option->value }}</li>
                        @endforeach
                    </ul>
                </li>

            @endforeach
        </ul>


        <h4>Product Groups</h4>
        <ul>
            @foreach($cart->groupedProducts as $group)

                <li>{{ $group[0]->product->title }} x{{ count($group) }}</li>

            @endforeach
        </ul>


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