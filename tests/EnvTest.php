<?php

class EnvTest extends TestCase
{
    public function testFacebook()
    {
        $this->assertTrue(env('FACEBOOK_CLIENT_ID') !== null);
        $this->assertTrue(env('FACEBOOK_SECRET') !== null);
    }

    public function testStripe()
    {
        $this->assertTrue(env('STRIPE_SECRET') !== null);
        $this->assertTrue(env('STRIPE_PUBLIC') !== null);
    }

    public function testMandrill()
    {
        $this->assertTrue(env('MANDRILL_SECRET') !== null);
    }

    public function testGoogle()
    {
        $this->assertTrue(env('GOOGLE_CLIENT_ID') !== null);
        $this->assertTrue(env('GOOGLE_SECRET') !== null);
    }

    public function testPaypal()
    {
        $this->assertTrue(env('PAYPAL_USERNAME') !== null);
        $this->assertTrue(env('PAYPAL_PASSWORD') !== null);
        $this->assertTrue(env('PAYPAL_SIGNATURE') !== null);
    }
}