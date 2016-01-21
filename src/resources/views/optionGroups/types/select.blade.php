@if(isset($optionGroup))

    <select class="form-control">
        @foreach($optionGroup->options as $option)
            <option>{{ $option->label }}</option>
        @endforeach
    </select>

@endif