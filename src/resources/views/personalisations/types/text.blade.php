<label for="personalisation[{{ $personalisation->id }}]">
    {{ $personalisation->label }}
    @if($personalisation->isPriceModifier)
        ({{ $personalisation->price_modifier_string }})
    @else
        (Free)
    @endif
</label>
<input type="text" id="personalisation[{{ $personalisation->id }}]" name="personalisation[{{ $personalisation->id }}]" class="form-control"
@if(isset($value) && $value !='')
    value="{{ $value }}"
@endif
/>