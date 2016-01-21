@if(isset($optionGroup))

    <label for="">{{ $optionGroup->title }}</label>
    <select class="form-control">
        @foreach($optionGroup->options as $option)
            <option>{{ $option->label }}</option>
        @endforeach
    </select>

@endif