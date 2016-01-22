@if(isset($cart))

    All Items
    <ul>
        @foreach($cart->products as $product)

            <li>{{ $product->product->title }}</li>

        @endforeach
    </ul>


    Product Groups
    <ul>
        @foreach($cart->groupedProducts as $group)

            <li>{{ $group[0]->product->title }} x{{ count($group) }}</li>

        @endforeach
    </ul>


@endif




@if(isset($data1))
    {{ var_dump($data1) }}
@endif

@if(isset($data2))
    {{ var_dump($data2) }}
@endif

@if(isset($data3))
    {{ var_dump($data3) }}
@endif