@section('title', trans('checkout.payment.form.title'))
@extends('pages.checkout.partials.template')

@section('css')
    @parent
    <style>
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        .credit-card-box .display-table {
            display: table;
            width: 100%
        }
        .credit-card-box .display-tr {
            display: table-row;
        }
        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        #card {
            padding-bottom: 20px;
        }

        .card-select .payment-selected {
            background-color: #FCF5EE;
            border: 1px solid #FBD8B4;
        }

        .card-select label {
            display: block;
            font-weight: inherit;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>{!! trans('checkout.payment.form.title') !!}</h1>
    </div>
    @include('pages.checkout.partials.order-step', ['active' => 'payment'])
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card -->
    <div class="panel-group" id="payment-methods">
        <div class="panel panel-default credit-card-box">
            <div class="panel-heading display-table">
                <div class="row display-tr panel-title">
                    <a role="button" class="display-td" data-toggle="collapse" data-parent="#payment-methods" href="#card">
                        <h4 class="panel-title">
                            <i class="fa fa-credit-card"></i> {!! trans('checkout.payment.form.card') !!}
                        </h4>
                    </a>
                    <div class="payment-method-img display-td">
                        <div class="pull-right">
                            <img src="/img/payment/master_card.png"
                                 alt="Master Card">
                            <img src="/img/payment/visa_card.png" alt="Visa">
                            <img src="/img/payment/american_express_card.png"
                                 alt="American Express">
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div id="card" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    @if(isset($cards) > 0)
                        <form action="{!! request()->url() !!}" class="card-select" method="POST">
                            {!! Form::token() !!}
                            <input type="hidden" name="method" value="stripe">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-8">
                                    <h4>Your cards</h4>
                                    <div class="your-cards">
                                        @foreach($cards as $c)
                                            <label>
                                                <div class="panel panel-default" data-card-id="{!! $c->id !!}">
                                                    <div class="panel-body">
                                                        <div class="col-xs-2">
                                                            <input type="radio" name="cardId" value="{!! $c->id !!}">
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <p>{!! trans('checkout.payment.form.card.show', ['brand' => $c->brand, 'last4' => $c->last4]) !!}</p>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <p class="pull-right">{!! trans('checkout.payment.form.card.expires') !!} {!! $c->exp_month !!}/{!! $c->exp_year !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <button class="btn btn-primary" type="submit">{!! trans('checkout.payment.form.card.button') !!}</button>
                                    <button class="btn btn-default pull-right" type="button" id="btn-add-card"><i class="fa fa-plus"></i> {!! trans('checkout.payment.form.card.new') !!}</button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <!-- Credit Card form -->
                    <div class="row" id="add-card" @if(isset($cards) > 0) style="display:none" @endif>
                        <div class="col-md-offset-4 col-md-4">
                            <form action="{!! request()->url() !!}" method="POST" id="stripe-form" class="form">
                                {!! Form::token() !!}
                                <input type="hidden" name="method" value="stripe">
                                <span class="payment-errors text-danger"></span>
                                <div class="form-group">
                                    <label>{!! trans('payment.card-number') !!}</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="card-brand">
                                            <i class="fa fa-credit-card"></i>
                                        </span>
                                        <input type="tel" size="20" class="form-control" id="card-number" autocomplete="cc-number" data-stripe="number"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{!! trans('payment.cardholder-name') !!}</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="card-name" value="{!! auth()->user()->name !!}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>CVC</label>
                                            <input type="tel" size="4" class="form-control" placeholder="CVC"
                                                   id="card-cvc" autocomplete="off" data-stripe="cvc"/>
                                        </div>
                                    </div>

                                    <div class="col-xs-6 pull-right">
                                        <div class="form-group">
                                            <label>{!! trans('checkout.payment.form.expiration') !!} (MM/YY)</label>
                                            <input type="tel" size="2" id="card-exp" class="form-control" placeholder="MM / YY"
                                                   data-stripe="exp-month"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="default">
                                            <input type="checkbox" name="defaultPayment" value="true" checked> {!! trans('checkout.payment.form.default') !!}
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">{!! trans('checkout.payment.form.card.button') !!}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PayPal -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#payment-methods" href="#paypal">
                        <i class="fa fa-paypal"></i> PayPal
                    </a>
                </h4>
            </div>
            <div id="paypal" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <form action="{!! request()->url() !!}" method="POST">
                                {!! Form::token() !!}
                                <input type="hidden" name="method" value="paypal">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">{!! trans('checkout.payment.form.pay-with', ['name' => 'PayPal']) !!}</button>
                                <div class="checkbox">
                                    <label for="">
                                        <input type="checkbox" name="defaultPayment" value="true" checked> {!! trans('checkout.payment.form.default') !!}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#payment-methods" href="#cash">
                        <i class="fa fa-money"></i> {!! trans('checkout.payment.form.cash') !!}
                    </a>
                </h4>
            </div>
            <div id="cash" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <p>{!! trans('checkout.payment.form.cash.desc') !!}</p>
                            <form action="{!! request()->url() !!}" method="POST">
                                {!! Form::token() !!}
                                <input type="hidden" name="method" value="cash">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">{!! trans('checkout.payment.form.pay-with', ['name' => trans('checkout.payment.form.cash')]) !!}</button>
                                <div class="checkbox">
                                    <label for="">
                                        <input type="checkbox" name="defaultPayment" value="true" checked> {!! trans('checkout.payment.form.default') !!}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.3.2/jquery.payment.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey('{!! config('services.stripe.public') !!}');

        jQuery(function($) {
            /*
             * Card Select
             */
            $('#btn-add-card').click(function() {
                $('#add-card').toggle('slow');
            });

            $('.card-select input').click(function() {
                $('.your-cards .panel').toggleClass('payment-selected', false);
                $(this).closest('.panel').toggleClass('payment-selected', true);
            });

            /*
             * Credit Card Form
             */
            $stripeForm = $('#stripe-form')

            $('#card-number').payment('formatCardNumber')
            $('#card-cvc').payment('formatCardCVC')
            $('#card-exp').payment('formatCardExpiry')

            $.fn.toggleInputError = function(erred) {
                this.closest('.form-group').toggleClass('has-error', erred);
                return this;
            };

            $stripeForm.find('#card-number').keyup(function() {
                var cardType = $.payment.cardType($('#card-number').val());

                if(cardType != null) {
                    $stripeForm.find('#card-brand').html($('<i>').attr('class', 'fa fa-cc-' + cardType));
                } else {
                    $stripeForm.find('#card-brand').html($('<i>').attr('class', 'fa fa-credit-card'));
                }
            });

            $('#card-number').keyup(validateNumber);
            $('#card-exp').keyup(validateExp);
            $('#card-cvc').keyup(validateCvc);
            $('#card-name').keyup(validateCardName);

            $stripeForm.submit(function(e) {
                e.preventDefault();

                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                validateNumber();
                validateExp();
                validateCvc();
                validateCardName();

                if($form.find('.has-error').length > 0) {
                    $form.find('button').prop('disabled', false);
                    return false;
                }

                Stripe.card.createToken({
                    number: $('#card-number').val(),
                    name: $('#card-name').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-exp').payment('cardExpiryVal').month,
                    exp_year: $('#card-exp').payment('cardExpiryVal').year
                }, stripeResponseHandler);
            });
        });

        function validateNumber() {
            $('#card-number').toggleInputError(!$.payment.validateCardNumber($('#card-number').val()));
        }

        function validateExp() {
            $('#card-exp').toggleInputError(!$.payment.validateCardExpiry($('#card-exp').payment('cardExpiryVal')));
        }

        function validateCvc() {
            var cardType = $.payment.cardType($('#card-number').val());
            $('#card-cvc').toggleInputError(!$.payment.validateCardCVC($('#card-cvc').val(), cardType));
        }

        function validateCardName() {
            var $cardName = $('#card-name')
            $cardName.toggleInputError($cardName.val().length === 0);
        }

        function stripeResponseHandler(status, response) {
            var $form = $('#stripe-form');

            var errorMessages = {
                invalid_number:       "{!! trans('errors.stripe.invalid_number') !!}",
                invalid_expiry_month: "{!! trans('errors.stripe.invalid_expiry_month') !!}",
                invalid_expiry_year:  "{!! trans('errors.stripe.invalid_expiry_year') !!}",
                invalid_cvc:          "{!! trans('errors.stripe.invalid_cvc') !!}",
                incorrect_number:     "{!! trans('errors.stripe.incorrect_number') !!}",
                expired_card:         "{!! trans('errors.stripe.expired_card') !!}",
                incorrect_cvc:        "{!! trans('errors.stripe.incorrect_cvc') !!}",
                incorrect_zip:        "{!! trans('errors.stripe.incorrect_zip') !!}",
                card_declined:        "{!! trans('errors.stripe.card_declined') !!}",
                missing:              "{!! trans('errors.stripe.missing') !!}",
                processing_error:     "{!! trans('errors.stripe.processing_error') !!}"
            };

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(errorMessages[response.error.code]);
                $form.find('button').prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }

    </script>
@endsection