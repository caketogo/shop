<?php

use OMS\Models\Order as Order;
use OMS\Models\OrderStatus as OrderStatus;
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

Route::get('/', function() {
	// Get an order
	$order = Order::findOrFail(1);

	// Get an Order Status
	$orderStatus = OrderStatus::findOrFail(2);

	$order->orderStatus()->associate($orderStatus);
	$order->save();

	dd($order);

	return "Done";

});

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/**
 * API Group
 */
Route::group(array('prefix' => 'api'), function() {
	/**
	 * API V1
	 */
	Route::group(array('prefix' => 'v1'), function() {

		// Could probably have an 'orders' group here

		/**
		 * This will return all orders on the system
		 */
		Route::get('/orders', ['as' => 'orders.index', 'uses' => 'OrderController@index']);

		/**
		 * This will add a new order to the system and return the newly created order
		 */
		Route::post('/orders', ['as' => 'orders.create', 'uses' => 'OrderController@create']);

		/**
		 * This will get a specific order off the cart
		 */
		Route::get('/orders/{cartid}', ['as' => 'orders.show', 'uses' => 'OrderController@show']);

		/**
		 * This will add the passed productid to the cart
		 */
		Route::post('/orders/{cartid}/add/{productid}', ['as' => 'orders.items.create', 'uses' => 'OrderController@createItem']);

		/**
		 * This will update the passed productid (for instance, quantity)
		 */
		Route::patch('/orders/{cartid}/update/{productid}', ['as' => 'orders.items.patch', 'uses' => 'OrderController@updateItem']);

		/**
		 * This will delete the passed productid from the order
		 */
		Route::delete('/orders/{cartid}/delete/{productid}', ['as' => 'orders.items.delete', 'uses' => 'OrderItemController@deleteItem']);

	});

});

// Some temporary config stuff, need to decide a proper place for this, probably config/app.php
Config::set('Orders::defaultStatus', 1);