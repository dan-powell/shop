@if(isset($image_types ))
    <div class="well -sm">
        
        <h3>Image Types</h3>
    
        <div class="row">
            @foreach($image_types as $key => $type)
            
                <div class="col-sm-3">
                
                    <h4><small>Image Type:</small> {{ config('shop.image_types.' . $key . '.title') }}</h4>
                    
                    @foreach($type as $image)
                        <a href="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" class="thumbnail">
                            <img src="{{ url() }}/{{ $image->path }}/{{ $image->filename }}" alt="{{ $image->alt }}" class="img-responsive"/>
                            @if(isset($image->title) && $image->title != '')
                            <div class="caption">
                                {{ $image->title }}
                            </div>
                            @endif
                        </a>
                    @endforeach
               
                </div>
            @endforeach
        </div>
    </div>
@endif