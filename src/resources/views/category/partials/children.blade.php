<div class="list-group">
    @foreach($children as $child)
        <a href="{{ route('shop.category.show', $child->slug) }}" class="list-group-item">
            {{ $child->title }}
        </a>

        @if( isset($child->children) && count($child->children) )
            @include('shop::category.partials.children', ['children' => $child->children] )
        @endif

    @endforeach
</div>
