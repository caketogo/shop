<?php namespace OMS\Http\Controllers;

use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use OMS\Http\Requests\API\CreateOrderRequest;

use Illuminate\Http\Request;

class OrdersAPIController extends APIController {

	/**
	 * Return all of the resources in the OMS. This will be paginated and return the most recent 20 by default.
	 *
	 * @return Response
	 */
	public function index()
	{
		$orders = Orders::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(CreateOrderRequest $request)
	{
		$order = new Order;

		// Set the 'default' order status
		$orderStatus = OrderStatus::find(Config::get('Orders::defaultStatus'));

		$orderStatus->order()->associate($order);



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

	public function addItem(AddItemToOrderRequest $request, $cartID, $itemID)
	{

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
