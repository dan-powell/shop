<label for="">{{ $personalisation->label }}</label>
<input type="text" name="personalisation[{{ $personalisation->id }}]" class="form-control"
@if(isset($value) && $value !='')
    value="{{ $value }}"
@endif
/>