@if(isset($option))
    <div class="form-group {{ $errors->has('option.' . $option->id) ? 'has-error' : '' }}">
        <label for="option[{{ $option->id }}]" class="control-label">{{ $option->title }}</label>
        <input
            type="text"
            class="form-control"
            name="option[{{ $option->id }}]"
            id="option[{{ $option->id }}]"
            value="{{ old('option.' . $option->id) }}"
        />
        {!! $errors->first('option.' . $option->id, '<p class="help-block">:message</p>') !!}
    </div>
@endif