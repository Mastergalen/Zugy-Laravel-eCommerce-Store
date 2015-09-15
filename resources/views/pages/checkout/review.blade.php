@section('title', 'Review order')
@extends('pages.checkout.partials.template')

@section('css')
    @parent

    <style>
        h4 .step-number {
            display: inline-block;
            width: 25px;
        }

        h4 {
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Review order</h1>
    </div>
    @include('pages.checkout.partials.order-step', ['active' => 'review'])
    @include('pages.checkout.partials.age-warning')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">1</span>Delivery Address</h4>
                </div>
                <div class="col-md-9">
                    <div class="pull-left">
                        <address>
                            {{$shippingAddress->name}}<br>
                            {{$shippingAddress->line_1}}<br>
                            @if($shippingAddress->line_2 != ""){{$shippingAddress->line_2}}<br>@endif
                            {{$shippingAddress->city}}, {{$shippingAddress->postcode}}<br>
                            <i class="fa fa-phone"></i> {{$shippingAddress->phone}}<br>
                            Delivery instructions: {{$shippingAddress->delivery_instructions}}<br>
                        </address>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm" href="{!! localize_url('routes.checkout.address') !!}?change">Change</a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">2</span>Payment Method</h4>
                </div>
                <div class="col-md-9">
                    <div class="pull-left">
                        @if($payment['method'] == 'card')
                            <p><i class="fa fa-credit-card"></i> <b>{{ $payment['card']['brand'] }}</b> ending in {{ $payment['card']['last4'] }}</p>
                        @elseif($payment['method'] == 'paypal')
                            <p><i class="fa fa-paypal"></i> {{ $payment['email'] }}</p>
                        @endif
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm" href="{!! localize_url('routes.checkout.payment') !!}?change">Change</a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">3</span>Review items</h4>
                </div>
                <div class="col-md-9">
                    <h4>Estimated delivery: Between 1-2 hours</h4>
                    @include('pages.checkout.partials.review-items')
                </div>
            </div>
        </div>
        <hr class="visible-xs"/>
        <div class="col-lg-3 col-md-3 col-sm-5">
            @include('pages.checkout.partials.order-summary')
            <form action="{!! localize_url('routes.checkout.review') !!}" method="POST">
                {!! Form::token() !!}
                <button class="btn btn-block btn-lg btn-success" type="submit">
                    <i class="fa fa-check-square"></i> Place order
                </button>
            </form>
            <small>By placing your order you agree to {!! config('site.name') !!}'s Privacy Policy and Terms and Conditions.</small><!--TODO Fix links-->

        </div>
        </div>
    </div>

    <div id="vat-popover-template" style="display:none">
        <table class="table">
            <tr>
                <td>Total before VAT</td>
                <td class="price">{!! money_format("%i", Cart::totalBeforeVat())  !!}&euro;</td>
            </tr>
            <tr>
                <td>VAT</td>
                <td class="price">{!! money_format("%i", Cart::vat()) !!}&euro;</td>
            </tr>
            <tr class="total">
                <td>Order Total</td>
                <td class="price">{!! money_format("%i", Cart::grandTotal()) !!}&euro;</td>
            </tr>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#vat-expand').popover({
                html: true,
                title: 'VAT Summary',
                placement: 'bottom',
                content: $('#vat-popover-template').html()
            })
        });
    </script>
@endsection