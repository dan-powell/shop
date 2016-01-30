@if(isset($option) && isset($option['config']) && count($option['config']))
    <div class="form-group">
        <label for="option[{{ $option->id }}]">{{ $option->title }}</label>
        <select class="form-control" name="option[{{ $option->id }}]" id="option[{{ $option->id }}]">
            @foreach($option['config'] as $key => $value)
                <option value="{{ $value }}" @if($key == 0)selected @endif>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
@endif