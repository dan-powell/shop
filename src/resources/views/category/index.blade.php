@extends('shop::base')

@section('main')
    <h1>Category Index</h1>

    @if(isset($categories) && count($categories) > 0)
        <div class="well">
            <h2>All Categories</h2>
            <div class="row">

                @foreach($categories as $key => $category)
                    <div class="col-md-4">
                        @include('shop::category.partials.snippet', ['category' => $category] )
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


    @if(isset($categories))
        <hr/>

        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#modelArray" aria-expanded="false" aria-controls="modelArray">
            Display Model Array
        </a>
        <div class="collapse" id="modelArray">
            <pre class="">
                {{ var_dump($categories->toArray()) }}
            </pre>
        </div>
    @endif

@stop