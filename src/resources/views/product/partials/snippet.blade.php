<div class="thumbnail">

    @foreach($product->images as $image)
        @if($image->pivot->image_type == 'thumb')
            <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}"/>
        @endif
    @endforeach

    <div class="caption">
        <h3>{{ $product->title }}</h3>
        <p>{{ $product->description }}</p>
        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary" role="button">View</a>
    </div>
</div>
