{{ var_dump($order) }}



<form action="{{ route('shop.order.confirm') }}" method="POST">
    
    {!! csrf_field() !!}
    
    <input type="text" name="id" value="{{ $order->id }}"/>
    
    <button class="btn btn-primary">
        Confirm
    </button>
</form>