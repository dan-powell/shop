<ul>

    @foreach($children as $child)
        <li>
            <a href="{{ route('category.show', $child->slug) }}">
                {{ $child->title }}
            </a>

             @if( isset($child->children) && count($child->children) )
                @include('shop::category.partials.children', ['children' => $child->children] )
            @endif


        </li>
    @endforeach



</ul>
