<div class="row">
    <div class="col-sm-12">

            {{ var_dump($order) }}


                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>Options</th>
                        <th>Personalisations</th>
                        <th>Options Total</th>
                    </tr>
                    </thead>
                    <tbody>

                    {{--{{ dd($cart['cart_items']) }}--}}

                    {{--@foreach($cart->cart_items as $item)--}}

                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--@if(isset($item->options) && $item->options != '')--}}
                                    {{--<ul>--}}
                                        {{--@foreach($item->options as $optionGroup)--}}

                                            {{--<li><strong>{{ $optionGroup['title'] }}</strong>: {{ $optionGroup['option']['label'] }} <span class="badge">{{ $optionGroup['option']['price_modifier_string'] }}</span></li>--}}
                                        {{--@endforeach--}}
                                    {{--</ul>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--@if(isset($item->personalisations) && $item->personalisations != '')--}}
                                    {{--<ul>--}}
                                        {{--@foreach($item->personalisations as $personalisation)--}}
                                            {{--<li><strong>{{ $personalisation['label'] }}</strong>: {{ $personalisation['value'] }}</li>--}}
                                        {{--@endforeach--}}
                                    {{--</ul>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--{{ $item->sub_total }}--}}
                            {{--</td>--}}
                        {{--</tr>--}}


                    {{--@endforeach--}}


                    </tbody>
                </table>

 </div>
    </div>


<form action="{{ route('shop.order.confirm') }}" method="POST">
    
    {!! csrf_field() !!}
    
    <input type="text" name="id" value="{{ $order->id }}"/>
    
    <button class="btn btn-primary">
        Confirm
    </button>
</form>