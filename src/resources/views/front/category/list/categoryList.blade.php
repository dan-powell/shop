@if(isset($categories) && count($categories))
    <div class="list-group list-group-root well">
        @foreach($categories as $key => $category)

            <a href="{{ route('shop.category.show', $category->slug) }}" class="list-group-item">
                <i class="glyphicon glyphicon-chevron-right"></i> {{ $category->title }}
            </a>

            @if( isset($category->children) && count($category->children) )
                @include('shop::front.category.list.partials.categoryListChildren', ['children' => $category->children] )
            @endif

        @endforeach
    </div>
@endif