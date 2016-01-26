@if(isset($optionGroup))
    <label for="optionGroup[{{ $optionGroup->id }}]">{{ $optionGroup->title }}</label>
    <select class="form-control" name="optionGroup[{{ $optionGroup->id }}]">
        @foreach($optionGroup->options as $option)
            <option value="{{ $option->id }}" @if($optionGroup->default)selected @endif>{{ $option->label }}
                @if($option->isPriceModifier)
                    ({{ $option->price_modifier_string }})
                @endif
            </option>
        @endforeach
    </select>
@endif