@if(isset($optionGroup))

    <div class="radio">
        @foreach($optionGroup->options as $key => $option)
            <label>
                <input type="radio" name="optionGroup[{{ $optionGroup->id }}]" id="optionGroup{{ $optionGroup->id }}_{{ $option->id }}" value="{{ $option->id }}" @if($key == 0)checked @endif>
                {{ $option->label }} ({{ $option->nice_price }})
            </label>
        @endforeach
    </div>

@endif