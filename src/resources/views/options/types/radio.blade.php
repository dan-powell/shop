@if(isset($option) && isset($option['config']) && count($option['config']))
    <div class="form-group">
        <p><strong>{{ $option->title }}</strong></p>
        @foreach($option['config'] as $key => $value)
            <div class="radio">
                <label>
                    <input type="radio" name="option[{{ $option->id }}]" id="option{{ $option->id }}" value="{{ $value }}" @if($key == 0)checked @endif>
                    {{ $value }}
                </label>
            </div>
        @endforeach
    </div>
@endif