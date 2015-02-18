<?php namespace OMS\Http\Controllers;


use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use OMS\Http\Requests\API\CreateOrderRequest;
use OMS\Models\Order as Order;
use OMS\Models\OrderItem as OrderItem;

use OMS\Models\Product as Product;

use Illuminate\Http\Request;
use Response;
use Input;

class OrdersAPIController extends ApiController {

	/**
	 * Return all of the resources in the OMS. This will be paginated and return the most recent 20 by default.
	 *
	 * @return Response
	 */
	public function index()
	{

		
		$orders = Order::all();

		dd($orders);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$order = new Order;

		// Set the 'default' order status
		//$orderStatus = OrderStatus::find(Config::get('Orders::defaultStatus'));

		//$orderStatus->order()->associate($order);



		// Save the order
		$order->save();

		// Return the response, with the order, as JSON
		return Response::json($order);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}



	/*
	* empties the cart
	*/
	public function emptyItems($order_id){

		$order = Order::where('id',$order_id)->first();
		$order->deleteItem();
			// Return the response, with the order, as JSON
		return Response::json($order);
	}


	/*
	* adds an item to the order
	* we need to get our price here
	* by finding the product and getting the price
	*/
	public function addItem($order_id)
	{


		
		$order = Order::where('id',$order_id)->first();
		$product = Product::where('id',Input::get('id'))->first();


		$item = array(
					'order_id' => $order_id,
					'product_id' => Input::get('id'),
					'qty' => Input::get('qty'),
					'description' => $product['name'],
					'price' => $product['price'],
					'cost' => $product['cost']

				);

		$order_item = OrderItem::create($item);
		$order->sync();


		return $order_id;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$order = Order::with('orderItem')->find($id);
		//$order->sync();
		return Response::json($order);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
