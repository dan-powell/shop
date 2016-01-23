<div class="thumbnail">

    <a href="{{ route('shop.category.show', $category->slug) }}">
        @if(isset($category->image_types['thumb']) && count($category->image_types['thumb']))
            @foreach($category->image_types['thumb'] as $key => $image)
                @if($key < 1)
                    <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}" class="img-responsive"/>
                @endif
            @endforeach
        @else
            <img src="holder.js/320x200" alt="{{ $category->title }}" class="img-responsive"/>
        @endif
    </a>

    <div class="caption">
        <h3>
            <a href="{{ route('shop.category.show', $category->slug) }}">
                {{ $category->title }}
            </a>
        </h3>
        <p>{{ String::words($category->description, 10) }}</p>

        @if( isset($category->children) && count($category->children) )
            @include('shop::category.partials.children', ['children' => $category->children] )
        @endif

    </div>
</div>
