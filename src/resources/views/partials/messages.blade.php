@if(session()->has('alert-success'))
    <div class="alert alert-success">
        <p>{{ session()->get('alert-success') }}</p>
    </div>
@endif

@if(session()->has('alert-warning'))
    <div class="alert alert-warning">
        <p>{{ session()->get('alert-warning') }}</p>
    </div>
@endif

@if(session()->has('alert-danger'))
    <div class="alert alert-danger">
        <p>{{ session()->get('alert-danger') }}</p>
    </div>
@endif

@if(session()->has('alert-info'))
    <div class="alert alert-info">
        <p>{{ session()->get('alert-info') }}</p>
    </div>
@endif