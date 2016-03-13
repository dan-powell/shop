@if(isset($option))
    <div class="form-group {{ $errors->has('option.' . $option->id) ? 'has-error' : '' }}">
        <label for="option[{{ $option->id }}]" class="control-label">{{ $option->title }}</label>
        <textarea
            type="text"
            class="form-control"
            name="option[{{ $option->id }}]"
            id="option[{{ $option->id }}]"
        >{{ old('option.' . $option->id) }}</textarea>
        {!! $errors->first('option.' . $option->id, '<p class="help-block">:message</p>') !!}
    </div>
@endif