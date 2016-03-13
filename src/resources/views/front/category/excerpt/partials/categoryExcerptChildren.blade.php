<ul>
    @foreach($children as $child)
        <li>
            <a href="{{ route('shop.category.show', $child->slug) }}">
                {{ $child->title }}
            </a>

            @if( isset($child->children) && count($child->children) )
                @include('shop::front.category.excerpt.partials.categoryExcerptChildren', ['children' => $child->children] )
            @endif

        </li>
    @endforeach
</ul>
