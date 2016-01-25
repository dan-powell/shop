<div class="form-horizontal">

    <h3>Billing Details</h3>

    <div class="form-group {{ $errors->has('billingAddress1') ? 'has-error' : '' }}">
        <label for="billingAddress1" class="col-sm-2 control-label">Address 1</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingAddress1" name="billingAddress1" value="{{ old('billingAddress1') }}">
            {!! $errors->first('billingAddress1', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingAddress2') ? 'has-error' : '' }}">
        <label for="billingAddress2" class="col-sm-2 control-label">Address 2</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingAddress2" name="billingAddress2" value="{{ old('billingAddress2') }}">
            {!! $errors->first('billingAddress2', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingCity') ? 'has-error' : '' }}">
        <label for="billingCity" class="col-sm-2 control-label">City</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingCity" name="billingCity" value="{{ old('') }}">
            {!! $errors->first('billingCity', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingPostcode') ? 'has-error' : '' }}">
        <label for="billingPostcode" class="col-sm-2 control-label">Postcode</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingPostcode" name="billingPostcode" value="{{ old('billingPostcode') }}">
            {!! $errors->first('billingPostcode', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingState') ? 'has-error' : '' }}">
        <label for="billingState" class="col-sm-2 control-label">County</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingState" name="billingState" value="{{ old('billingState') }}">
            {!! $errors->first('billingState', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingCountry') ? 'has-error' : '' }}">
        <label for="billingCountry" class="col-sm-2 control-label">Country</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingCountry" name="billingCountry" value="{{ old('billingCountry') }}">
            {!! $errors->first('billingCountry', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

</div>



