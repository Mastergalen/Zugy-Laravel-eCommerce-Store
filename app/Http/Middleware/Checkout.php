<?php

namespace App\Http\Middleware;

use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Auth\Guard;

class Checkout
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Cart::count() == 0) {
            return redirect(localize_url('routes.cart'));
        }

        if ($this->auth->guest() && !session()->has('checkout.guest')) {
            return redirect()->guest(localize_url('routes.checkout.landing'));
        }

        return $next($request);
    }
}
