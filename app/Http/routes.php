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
// Display all SQL executed in Eloquent

Route::get('/', function() {



	// Get an order
	$order= OMS\Models\OrderItem::create(array('product_id'=>123,'order_id' => 234,'qty' => 1));
	dd($order);

	/*
	// Get an order
	$order = Order::findOrFail(1);

	// Get an Order Status
	$orderStatus = OrderStatus::findOrFail(2);

	$order->orderStatus()->associate($orderStatus);
	$order->save();

	dd($order);

	return "Done";
	*/

});
#
Route::controller('site', 'SiteController');
Route::controller('product', 'ProductController');


#Route::get('/orders/add', ['as' => 'orders.add', 'uses' => 'OrdersAPIController@add']);
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
		Route::get('/orders', ['as' => 'orders.index', 'uses' => 'OrdersAPIController@index']);

		/**
		 * This will add a new order to the system and return the newly created order
		 */
		Route::post('/orders', ['as' => 'orders.create', 'uses' => 'OrdersAPIController@create']);

		/**
		 * This will get a specific order off the cart
		 */
		Route::get('/orders/{cartid}', ['as' => 'orders.show', 'uses' => 'OrdersAPIController@show']);

		/**
		 * This will add the passed productid to the cart
		 */
		Route::post('/orders/{cartid}/add', ['as' => 'orders.items.add', 'uses' => 'OrdersAPIController@addItem']);

		/**
		 * This will update the passed productid (for instance, quantity)
		 */
		Route::patch('/orders/{cartid}/update/{productid}', ['as' => 'orders.items.patch', 'uses' => 'OrdersAPIController@updateItem']);

		/**
		 * This will delete the passed productid from the order
		 */
		Route::delete('/orders/{cartid}/delete/{productid}', ['as' => 'orders.items.delete', 'uses' => 'OrderItemController@deleteItem']);


		/**
		 * This will empty the passed cartid ** not sure this is correct way to do it.
		*/
		Route::get('/orders/{cartid}/empty', ['as' => 'orders.empty', 'uses' => 'OrdersAPIController@emptyItems']);

		/**
		 * create a new transaction agains an order
		 */
		Route::get('/orders/{id}/transaction', ['as' => 'orders.transaction', 'uses' => 'OrdersAPIController@transaction']);

		Route::get('/orders/{id}/pay', ['as' => 'orders.pay', 'uses' => 'OrdersAPIController@pay']);

		Route::get('/orders/{id}/complete', ['as' => 'orders.complete', 'uses' => 'OrdersAPIController@complete']);

		/*


		//products

		/**
		* return all the products
		*/
		//Route::get('/products', ['as' => 'products.index', 'uses' => 'ProductsAPIController@index']);

		/**
		* return single product specified in id
		*/
		//Route::get('/products/{id}', ['as' => 'products.show', 'uses' => 'ProductsAPIController@show']);
		
		/**
		 * Products
		 */
		Route::group(array('prefix' => 'products'), function() {

			Route::post('/', [
				'as' => 'products.create',
				'uses' => 'ProductsAPIController@create'
			]);

				Route::get('/add/', [
				'as' => 'products.test',
				'uses' => 'ProductsAPIController@test'
			]);

			Route::get('/', [
				'as' => 'products.index',
				'uses' =>'ProductsAPIController@index'
			]);

			Route::get('/{id}', [
				'as' => 'products.show',
				'uses' => 'ProductsAPIController@show'
			]);

			Route::patch('/{id}', [
				'as' => 'products.update',
				'uses' => 'ProductsAPIController@update'
			]);

			Route::delete('/{id}', [
				'as' => 'products.delete',
				'uses' => 'ProductsAPIController@delete'
			]);
		});




		/**
		 * CUSTOMERS
		 */
		Route::group(array('prefix' => 'customers'), function() {

			Route::post('/', [
				'as' => 'customers.create',
				'uses' => 'CustomersAPIController@create'
			]);

			Route::get('/', [
				'as' => 'customers.index',
				'uses' =>'CustomersAPIController@index'
			]);

			Route::get('/{id}', [
				'as' => 'customers.show',
				'uses' => 'CustomersAPIController@show'
			]);

			Route::patch('/{id}', [
				'as' => 'customers.update',
				'uses' => 'CustomersAPIController@update'
			]);

			Route::post('/login', [
				'as' => 'customers.login',
				'uses' => 'CustomersAPIController@login'
			]);

			//address stuff
				Route::post('/{id}/addresses', [
				'as' => 'customers.address.create',
				'uses' => 'CustomersAPIController@create_address'
			]);

				Route::get('/{id}/addresses', [
				'as' => 'customers.address.index',
				'uses' => 'CustomersAPIController@index_address'
			]);


		});
		/**
		 * PAYMENTS
		 */
		Route::group(array('prefix' => 'payments'), function() {

			Route::post('/{id}', [
				'as' => 'payments.create',
				'uses' => 'PaymentsAPIController@create'
			]);
			

			Route::get('/methods', [
				'as' => 'payments.methods',
				'uses' =>'PaymentsAPIController@methods'
			]);

			Route::get('/methods/{id}', [
				'as' => 'payments.methods',
				'uses' =>'PaymentsAPIController@show_method'
			]);
			
			Route::get('/pay/{id}', [
				'as' => 'payments.pay',
				'uses' => 'PaymentsAPIController@pay'
			]);
/*
			Route::patch('/{id}', [
				'as' => 'customers.update',
				'uses' => 'CustomersAPIController@update'
			]);

			Route::post('/login', [
				'as' => 'customers.login',
				'uses' => 'CustomersAPIController@login'
			]);

			//address stuff
				Route::post('/{id}/addresses', [
				'as' => 'customers.address.create',
				'uses' => 'CustomersAPIController@create_address'
			]);

				Route::get('/{id}/addresses', [
				'as' => 'customers.address.index',
				'uses' => 'CustomersAPIController@index_address'
			]);

			*/
		});


	});

});

// Some temporary config stuff, need to decide a proper place for this, probably config/app.php
Config::set('Orders::defaultStatus', 1);