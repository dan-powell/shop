@extends('shop::base')

@section('main')


    @if(isset($category->image_types['hero']))
        <div class="jumbotron" style="background-image: url('{{ url() }}/{{ $category->image_types['hero'][0]->path }}/{{ $category->image_types['hero'][0]->filename }}'); background-size: cover;">
            <h1>{{ $category->title }}</h1>
        </div>
    @else
        <h1>{{ $category->title }}</h1>
    @endif
    

    @if(isset($category->description) && $category->description != '')
        <hr/>
            {!! Markdown::parse($category->description) !!}
        <hr/>
    @endif
    

    @if(isset($category->image_types) && count($category->image_types))
        @include('shop::partials.imageTypes', ['image_types' => $category->image_types])
    @endif


    @if(isset($category->products) && count($category->products))
        <div class="well">
            <h2>Products</h2>
            <div class="row">
                @foreach($category->products as $key => $product)

                    <div class="col-sm-6">
                        @include('shop::product.partials.snippet', ['product' => $product])
                    </div>

                @endforeach
            </div>
        </div>
    @endif


    @if(isset($category->categories) && count($category->categories))
        <div class="well">
            <h2>Sub Categories</h2>
            <div class="row">
                @foreach($category->categories as $key => $category)

                    <div class="col-sm-6">
                        @include('shop::category.partials.snippet', ['category' => $category])
                    </div>

                @endforeach
            </div>
        </div>
    @endif



    @if(isset($category->children) && count($category->children))
        <div class="well">
            <h2>Sub Categories</h2>

            @foreach($category->children as $category)
                <a href="{{ route('shop.category.show', $category->slug) }}" class="list-group-item">
                    {{ $category->title }}
                </a>
            @endforeach
        </div>
    @endif




    @if(isset($category))
        <hr/>

        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Model Array
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($category->toArray()) }}
            </pre>
        </div>
    @endif

@stop