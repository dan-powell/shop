@if(old('success') && old('success') != null)
    <div class="alert alert-success">
        <p>{{ old('success') }}</p>
    </div>
@endif

@if(old('warning') && old('warning') != null)
    <div class="alert alert-warning">
        <p>{{ old('warning') }}</p>
    </div>
@endif