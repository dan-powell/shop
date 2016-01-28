<label for="personalisation[{{ $personalisation->id }}]">
    {{ $personalisation->label }}
    @if($personalisation->isPriceModifier)
        ({{ $personalisation->price_modifier_string }})
    @else
        (Free)
    @endif
</label>
<textarea class="form-control" rows="6" name="personalisation[{{ $personalisation->id }}]" id="personalisation[{{ $personalisation->id }}]">
@if(isset($value) && $value != '')
{{ $value }}
@endif
</textarea>
