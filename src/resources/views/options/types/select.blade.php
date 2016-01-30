@if(isset($option) && isset($option['config']) && count($option['config']))
    <div class="form-group {{ $errors->has('option.' . $option->id) ? 'has-error' : '' }}">
        <label for="option[{{ $option->id }}]" class="control-label">{{ $option->title }}</label>
        <select class="form-control" name="option[{{ $option->id }}]" id="option[{{ $option->id }}]">
            @foreach($option['config'] as $key => $value)
                <option
                    value="{{ $value }}"
                    @if($value == old('option.' . $option->id))selected @endif
                >
                    {{ $value }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('option.' . $option->id, '<p class="help-block">:message</p>') !!}
    </div>
@endif