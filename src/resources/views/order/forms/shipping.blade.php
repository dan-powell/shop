<div class="form-horizontal">

    <h3>Delivery Details</h3>

    <div class="form-group {{ $errors->has('shippingAddress1') ? 'has-error' : '' }}">
        <label for="shippingAddress1" class="col-sm-2 control-label">Address 1</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingAddress1" name="shippingAddress1" value="{{ old('shippingAddress1') }}">
            {!! $errors->first('shippingAddress1', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingAddress2') ? 'has-error' : '' }}">
        <label for="shippingAddress2" class="col-sm-2 control-label">Address 2</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingAddress2" name="shippingAddress2" value="{{ old('shippingAddress2') }}">
            {!! $errors->first('shippingAddress2', '<p class="text-red">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('shippingCity') ? 'has-error' : '' }}">
        <label for="shippingCity" class="col-sm-2 control-label">City</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingCity" name="shippingCity" value="{{ old('') }}">
            {!! $errors->first('shippingCity', '<p class="text-red">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('shippingPostcode') ? 'has-error' : '' }}">
        <label for="shippingPostcode" class="col-sm-2 control-label">Postcode</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingPostcode" name="shippingPostcode" value="{{ old('shippingPostcode') }}">
            {!! $errors->first('shippingPostcode', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingState') ? 'has-error' : '' }}">
        <label for="shippingState" class="col-sm-2 control-label">County</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingState" name="shippingState" value="{{ old('shippingState') }}">
            {!! $errors->first('shippingState', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingCountry') ? 'has-error' : '' }}">
        <label for="shippingCountry" class="col-sm-2 control-label">Country</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingCountry" name="shippingCountry" value="{{ old('shippingCountry') }}">
            {!! $errors->first('shippingCountry', '<p class="text-red">:message</p>') !!}
        </div>
    </div>

</div>

