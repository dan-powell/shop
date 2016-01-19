<a href="{{ route('shop.product.show', $product->slug) }}" class="thumbnail">

    @if(isset($product->image_types['thumb']) && count($product->image_types['thumb']))
        @foreach($product->image_types['thumb'] as $key => $image)
            <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}"/>
        @endforeach
    @else
        <img src="holder.js/320x200" alt="{{ $product->title }}">
    @endif

    <div class="caption">
        <h3>{{ $product->title }}</h3>
        <p>{{ String::words($product->description, 10) }}</p>
    </div>
</a>
