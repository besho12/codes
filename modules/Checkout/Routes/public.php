<?php

use Illuminate\Support\Facades\Route;

Route::get('checkout', 'CheckoutController@create')->name('checkout.create');
Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
Route::post('paymob', 'PaymobController@paymob_create_order')->name('paymob.paymob_create_order');
Route::post('paymobcallback', 'PaymobController@callback')->name('paymob.callback')->withoutMiddleware(\FleetCart\Http\Middleware\VerifyCsrfToken::class);
Route::get('paymobcallbackresponseview', 'PaymobController@paymobcallbackresponseview')->name('paymob.paymobcallbackresponseview')->withoutMiddleware(\FleetCart\Http\Middleware\VerifyCsrfToken::class);

Route::any('checkout/{orderId}/complete', 'CheckoutCompleteController@store')
    ->name('checkout.complete.store')
    ->withoutMiddleware(\FleetCart\Http\Middleware\VerifyCsrfToken::class);
Route::get('checkout/complete', 'CheckoutCompleteController@show')->name('checkout.complete.show');

Route::get('checkout/{orderId}/payment-canceled', 'PaymentCanceledController@store')->name('checkout.payment_canceled.store');


