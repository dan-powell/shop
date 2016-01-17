@if(count($categories))
    <div class="list-group list-group-root well">
        @foreach($categories as $key => $category)

            <a href="{{ route('category.show', $category->slug) }}" class="list-group-item">
                <i class="glyphicon glyphicon-chevron-right"></i> {{ $category->title }}
            </a>

            @if( isset($category->children) && count($category->children) )
                @include('shop::category.partials.children', ['children' => $category->children] )
            @endif

        @endforeach
    </div>
@endif