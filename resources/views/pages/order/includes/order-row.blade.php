@foreach($order->items as $item)
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <div class="cart-product-thumb">
                        <a href="{!! $item->product()->withTrashed()->first()->getUrl() !!}"><img
                                    src="{!! $item->product()->withTrashed()->first()->thumbnail_url !!}"
                                    alt="{{ $item->product()->withTrashed()->first()->title }}"></a>
                    </div>
                </div>
                <div class="col-xs-9">
                    <div class="cart-description">
                        <h4><a href="{!! $item->product()->withTrashed()->first()->getUrl() !!}">{{ $item->product()->withTrashed()->first()->title }}</a></h4>

                        <div class="price">{{ money_format("%i", $item->price) }}&euro;</div>

                        <p><b>{!! trans('product.quantity') !!}: </b>{!! $item->quantity !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach