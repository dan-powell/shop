<a href="{{ route('shop.category.show', $category->slug) }}" class="thumbnail">

    @if(isset($category->image_types['thumb']) && count($category->image_types['thumb']))
        @foreach($category->image_types['thumb'] as $key => $image)
            @if($key < 1)
                <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}"/>
            @endif
        @endforeach
    @else
        <img src="holder.js/320x200" alt="{{ $category->title }}">
    @endif

    <div class="caption">
        <h3>{{ $category->title }}</h3>
        <p>{{ String::words($category->description, 10) }}</p>
    </div>
</a>
