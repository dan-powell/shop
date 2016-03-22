<div class="form-horizontal">

    <h3>Billing Details</h3>

    <div class="form-group {{ $errors->has('billingAddress1') ? 'has-error' : '' }}">
        <label for="billingAddress1" class="col-sm-2 control-label">Address 1<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingAddress1" name="billingAddress1" value="{{ $order['billingAddress1'] or old('billingAddress1') }}">
            {!! $errors->first('billingAddress1', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingAddress2') ? 'has-error' : '' }}">
        <label for="billingAddress2" class="col-sm-2 control-label">Address 2</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingAddress2" name="billingAddress2" value="{{ $order['billingAddress2'] or old('billingAddress2') }}">
            {!! $errors->first('billingAddress2', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingCity') ? 'has-error' : '' }}">
        <label for="billingCity" class="col-sm-2 control-label">City<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingCity" name="billingCity" value="{{ $order['billingCity'] or old('billingCity') }}">
            {!! $errors->first('billingCity', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingPostcode') ? 'has-error' : '' }}">
        <label for="billingPostcode" class="col-sm-2 control-label">Postcode<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingPostcode" name="billingPostcode" value="{{ $order['billingPostcode'] or old('billingPostcode') }}">
            {!! $errors->first('billingPostcode', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingState') ? 'has-error' : '' }}">
        <label for="billingState" class="col-sm-2 control-label">County<span class="req"> *</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="billingState" name="billingState" value="{{ $order['billingState'] or old('billingState') }}">
            {!! $errors->first('billingState', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('billingCountry') ? 'has-error' : '' }}">
        <label for="billingCountry" class="col-sm-2 control-label">Country<span class="req"> *</span></label>
        <div class="col-sm-10">
            <select class="form-control" id="billingCountry" name="billingCountry">
                @foreach(config('shop.countries') as $key => $country)
                    <option value="{{ $key }}"
                            @if((isset($order['billingCountry']) && $key == $order['billingCountry']) || $key == old('billingCountry'))selected @endif
                            @if(!in_array($key, config('shop.countries_allow_billing')))disabled @endif
                    >
                        {{ $country['name'] }}
                        @if(!in_array($key, config('shop.countries_allow_billing')))&dagger; @endif
                    </option>
                @endforeach
            </select>
            <p><small>&dagger; We do not currently support payments from these countries.</small></p>
            {!! $errors->first('billingCountry', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>



