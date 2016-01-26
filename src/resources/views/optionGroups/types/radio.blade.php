@if(isset($optionGroup))

    <fieldset>
        <p><strong>{{ $optionGroup->title }}</strong></p>
    @foreach($optionGroup->options as $key => $option)
        <div class="radio">
            <label>
                <input type="radio" name="optionGroup[{{ $optionGroup->id }}]" id="optionGroup{{ $optionGroup->id }}_{{ $option->id }}" value="{{ $option->id }}" @if($optionGroup->default)checked @endif>
                {{ $option->label }}
                @if($option->isPriceModifier)
                    ({{ $option->price_modifier_string }})
                @endif
            </label>
        </div>
    @endforeach
    </fieldset>

@endif