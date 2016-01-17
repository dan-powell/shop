@extends('shop::base')

@section('main')
    <div class="container">

        <div class="row">
            <div class="col-sm-4">

                @include('shop::category.partials.list')

            </div>
            <div class="col-sm-8">

                <h1>{{ $category->title }}</h1>

                <div class="">
                    {{ $category->description }}
                </div>

                @if(count($category->products))
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



                @if(count($category_children))
                    <div class="well">
                        <h2>Sub Categories</h2>

                        @foreach($category_children as $category)
                            <a href="{{ route('category.show', $category->slug) }}" class="list-group-item">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>

                @endif

            </div>

        </div>
    </div>
@stop