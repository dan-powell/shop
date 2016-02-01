<div class="form-horizontal">

    <h3>Delivery Details</h3>

    <div class="form-group {{ $errors->has('shippingAddress1') ? 'has-error' : '' }}">
        <label for="shippingAddress1" class="col-sm-2 control-label">Address 1<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingAddress1" name="shippingAddress1" value="{{ $order['shippingAddress1'] or old('shippingAddress1') }}">
            {!! $errors->first('shippingAddress1', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingAddress2') ? 'has-error' : '' }}">
        <label for="shippingAddress2" class="col-sm-2 control-label">Address 2</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingAddress2" name="shippingAddress2" value="{{ $order['shippingAddress2'] or old('shippingAddress2') }}">
            {!! $errors->first('shippingAddress2', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('shippingCity') ? 'has-error' : '' }}">
        <label for="shippingCity" class="col-sm-2 control-label">City<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingCity" name="shippingCity" value="{{ $order['shippingCity'] or old('shippingCity') }}">
            {!! $errors->first('shippingCity', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    <div class="form-group {{ $errors->has('shippingPostcode') ? 'has-error' : '' }}">
        <label for="shippingPostcode" class="col-sm-2 control-label">Postcode<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingPostcode" name="shippingPostcode" value="{{ $order['shippingPostcode'] or old('shippingPostcode') }}">
            {!! $errors->first('shippingPostcode', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingState') ? 'has-error' : '' }}">
        <label for="shippingState" class="col-sm-2 control-label">County<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="shippingState" name="shippingState" value="{{ $order['shippingState'] or old('shippingState') }}">
            {!! $errors->first('shippingState', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('shippingCountry') ? 'has-error' : '' }}">
        <label for="shippingCountry" class="col-sm-2 control-label">Country<span class="req"> *</span></label>
        <div class="col-sm-10">
            <select class="form-control" id="shippingCountry" name="shippingCountry">
                @foreach(config('shop.countries') as $country)
                    <option value="{{ $country['code'] }}" @if((isset($order['shippingCountry']) && $order['shippingCountry'] == $country['code']) || $country['code'] == old('shippingCountry'))selected @endif>
                        {{ $country['name'] }} @if(!$country['allow_shipping'])* @endif
                    </option>
                @endforeach
            </select>
            {!! $errors->first('shippingCountry', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>

