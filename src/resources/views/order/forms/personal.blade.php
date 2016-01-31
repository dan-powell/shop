<div class="form-horizontal">

    <h3>Your details</h3>

    <div class="form-group {{ $errors->has('firstName') ? 'has-error' : '' }}">
        <label for="firstName" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Your forename" value="{{ old('firstName') }}">
            {!! $errors->first('firstName', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('lastName') ? 'has-error' : '' }}">
        <label for="lastName" class="col-sm-2 control-label">Last Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="lastName" name="lastName"  placeholder="Your surname" value="{{ old('lastName') }}">
            {!! $errors->first('lastName', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email"  placeholder="Your email address" value="{{ old('email') }}">
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('billingPhone') ? 'has-error' : '' }}">
        <label for="billingPhone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingPhone" name="billingPhone"  placeholder="Your phone number" value="{{ old('billingPhone') }}">
            {!! $errors->first('billingPhone', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>