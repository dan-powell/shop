@if(isset($optionGroup) && isset($optionGroup->options) && count($optionGroup->options))
    <div class="form-group">
        <p><strong>{{ $optionGroup->title }}</strong></p>
        @foreach($optionGroup->options as $key => $option)
            <div class="radio">
                <label>
                    <input type="radio" name="optionGroup[{{ $optionGroup->id }}]" id="optionGroup{{ $optionGroup->id }}_{{ $option->id }}" value="{{ $option->id }}" @if($key == 0)checked @endif @if($option->stock < 1 && $product->allow_negative_stock == 0)disabled @endif>

                    {{ $option->label }}

                    @if($option->isPriceModifier)
                        ({{ $option->price_modifier_string }})
                    @endif

                    @if($option->stock < 1 && $product->allow_negative_stock == 0)
                        Out of Stock
                    @endif

                </label>
            </div>
        @endforeach
    </div>
@endif