@extends('shop::base')

@section('main')
    <div class="container">
        <h1>Category Index</h1>

        @if(isset($categories) && count($categories) > 0)
            <div class="well">
                <h2>All Categories</h2>
                <div class="row">
                    @foreach($categories as $key => $category)
                        <div class="col-md-4">
                            {{--@include('portfolio::partials.thumb', ['project' => $project])--}}

                            <a href="{{ route('category.show', $category->slug) }}">
                                {{ $category->title }}
                            </a>
                        </div>

                        @if($key % 3 == 2)
                            <div class="clearfix visible-md-block visible-lg-block"></div>
                        @endif

                    @endforeach
                </div>
            </div>
        @else
            <p>No Categories found</p>
        @endif

    </div>
@stop