<?php

namespace Zugy\PaymentGateway\Gateways;

use App\Payment;

class Cash extends AbstractGateway
{
    protected $methodName = 'cash';

    public function addOrUpdateMethod() {
        $this->paymentMethod = $this->fetchPaymentMethod();

        if($this->paymentMethod === null) {
            $this->paymentMethod = $this->createPaymentMethod();
        }

        $this->setAsDefault(request('defaultPayment') !== null);

        return $this->paymentMethod;
    }

    public function charge($amount)
    {
        $payment = new Payment();

        $payment->status = 3; //Mark as "Payment on Delivery"

        $payment->amount = $amount;
        $payment->currency = 'EUR';
        $payment->method = $this->paymentMethod->method;

        return $payment;
    }

    public function getFormatted()
    {
        return [
            'method' => $this->methodName,
        ];
    }
}