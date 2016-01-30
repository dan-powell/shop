@if(isset($optionGroup) && isset($optionGroup->options) && count($optionGroup->options))
    <div class="form-group">
        <label for="optionGroup[{{ $optionGroup->id }}]">{{ $optionGroup->title }}</label>
        <select class="form-control" name="optionGroup[{{ $optionGroup->id }}]" id="optionGroup[{{ $optionGroup->id }}]">
            @foreach($optionGroup->options as $option)
                <option value="{{ $option->id }}" @if($optionGroup->default)selected @endif @if($option->stock < 1 && $optionGroup->allow_negative_stock == 0)disabled @endif>{{ $option->label }}

                    @if($option->isPriceModifier)
                        ({{ $option->price_modifier_string }})
                    @endif

                    @if($option->stock < 1 && $optionGroup->allow_negative_stock == 0)
                        Out of Stock
                    @endif

                </option>
            @endforeach
        </select>
    </div>
@endif