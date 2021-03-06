<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => (app()->environment('testing') ? 'en' : Localization::setLocale()),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect' ]
], function() {
    Route::get('/', function () {
        return view('pages.home');
    });
});

Route::group([
    'prefix' => (app()->environment('testing') ? 'en' : Localization::setLocale()),
    'middleware' => [ 'web', 'localize', 'localeSessionRedirect', 'setLocale'] // Route translate middleware
],
function() {
    /*
     * Account
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::get(Localization::transRoute('routes.account.index'), ['as' => 'your-account', 'uses' => 'AccountController@getHome']);
        Route::get(Localization::transRoute('routes.account.settings'), ['as' => 'your-account', 'uses' => 'AccountController@getSettings']);
        Route::get(Localization::transRoute('routes.account.orders'), ['uses' => 'AccountController@getOrders']);
    });

    Route::get(Localization::transRoute('routes.product'), ['uses' => 'ProductController@show']);

    Route::get(Localization::transRoute('routes.search'), ['uses' => 'ProductController@search']);
    /*
     * Shop
     */
    Route::get(Localization::transRoute('routes.shop.index'), ['uses' => 'ShopController@index', 'as' => 'shop']);
    Route::get(Localization::transRoute('routes.shop.category'), ['uses' => 'ShopController@category']);

    /*
     * Checkout
     */
    Route::get(Localization::transRoute('routes.checkout.landing'), ['uses' => 'CheckoutController@getCheckout']);

    Route::get(Localization::transRoute('routes.checkout.address'), ['uses' => 'CheckoutController@getCheckoutAddress']);
    Route::post(Localization::transRoute('routes.checkout.address'), ['uses' => 'CheckoutController@postCheckoutAddress']);
    Route::get(Localization::transRoute('routes.checkout.payment'), ['uses' => 'CheckoutController@getCheckoutPayment']);
    Route::post(Localization::transRoute('routes.checkout.payment'), ['uses' => 'CheckoutController@postCheckoutPayment']);
    Route::get(Localization::transRoute('routes.checkout.review'), ['uses' => 'CheckoutController@getCheckoutReview']);
    Route::post(Localization::transRoute('routes.checkout.review'), ['uses' => 'CheckoutController@postCheckoutReview']);
    Route::get(Localization::transRoute('routes.checkout.confirmation'), ['uses' => 'CheckoutController@getCheckoutConfirmation']);
    Route::get(Localization::transRoute('routes.checkout.gatewayReturn'), ['uses' => 'CheckoutController@getGatewayReturn']);

    Route::get(Localization::transRoute('routes.order.show'), ['uses' => 'OrderController@show']);

    /* Cart */
    Route::get(Localization::transRoute('routes.cart'), ['uses' => 'PageController@getCart']);

    Route::get(Localization::transRoute('routes.about-us'), function () {
        return view('pages.about-us');
    });

    Route::get(Localization::transRoute('routes.contact'), function () {
        return view('pages.contact');
    });

    Route::get(Localization::transRoute('routes.terms-and-conditions'), function() {
        return view('pages.terms-and-conditions.index');
    });
    Route::get(Localization::transRoute('routes.privacy-policy'), function() {
        return view('pages.privacy-policy.index');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
        Route::post('login', ['uses' => 'Auth\AuthController@postLogin']);

        Route::get('register', ['uses' => 'Auth\AuthController@getRegister']);
        Route::post('register', ['uses' => 'Auth\AuthController@postRegister']);

        /*
         * Password reset
         */
        Route::get('password/email', ['uses' => 'Auth\PasswordController@getEmail']);
        Route::post('password/email', ['uses' => 'Auth\PasswordController@postEmail']);
        Route::get('password/reset/{token}', ['uses' => 'Auth\PasswordController@getReset']);
        Route::post('password/reset', ['uses' => 'Auth\PasswordController@postReset']);
        Route::post('password/change', ['uses' => 'Auth\PasswordController@postPasswordChange']);
    });
});

/*
 * No localisation needed
 */
Route::group(['prefix' => 'auth', 'middleware' => ['web']], function () {
    Route::get('login/facebook', 'Auth\AuthController@facebookLogin');
    Route::get('login/google', 'Auth\AuthController@googleLogin');
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

    Route::post('adminLogin', ['uses' => 'Auth\AuthController@postAdminLogin']);
});

/* API */
Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::group(['prefix' => 'v1'], function () {
        //No auth required
        Route::patch('cart', 'API\CartController@bulkUpdate');
        Route::resource('cart', 'API\CartController', ['except' => [
            'update',
            'show'
        ]]);
        Route::get('postcode/check/{postcode}', ['uses' => 'API\PostcodeController@checkPostcode']);

        //Auth required
        Route::group(['middleware' => ['auth']], function () {
            Route::resource('address', 'API\AddressController');
            Route::resource('order', 'API\OrderController');
            Route::post('coupon/apply', 'API\CouponController@apply');
        });

        Route::group(['prefix' => 'shop'], function() {
            Route::get('statistics', 'API\ShopStatisticsController@getStatistics');
        });
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'admin', 'setLocale']], function () {
    Route::get('', ['uses' => 'Admin\DashboardController@getDashboard']);

    Route::resource('catalogue', 'Admin\CatalogueController');
    Route::resource('customer', 'Admin\CustomerController');
    Route::resource('order', 'Admin\OrderController');
    Route::post('image/upload', 'Admin\ImageController@upload');
    Route::delete('image/{id}', 'Admin\ImageController@destroy');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('test', function() {
    });
});
