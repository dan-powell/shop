@if(isset($option) && isset($option['config']) && count($option['config']))
    <div class="form-group {{ $errors->has('option.' . $option->id) ? 'has-error' : '' }}">
        <p><strong>{{ $option->title }}</strong></p>
        @foreach($option['config'] as $key => $value)
            <div class="radio">
                <label>
                    <input type="radio" name="option[{{ $option->id }}]" id="option{{ $option->id }}" value="{{ $value }}" @if($value == old('option.' . $option->id) || ($value != old('option.' . $option->id) && $key == 0))checked @endif>
                    {{ $value }}
                </label>
            </div>
        @endforeach
        {!! $errors->first('option.' . $option->id, '<p class="help-block">:message</p>') !!}
    </div>
@endif