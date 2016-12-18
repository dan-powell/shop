{!! Notification::showAll() !!}

@if(isset($errors) && count($errors->all()))
    <div class="alert alert-warning">
        <p><strong>The following errors occured:</strong></p>
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
