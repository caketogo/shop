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
use View;
use Redirect;

use Omnipay\Omnipay;

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
					'quantity' => Input::get('quantity'),
					'name' => $product['name'],
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


/*
	function pay(){

		if(Input::get('stripeToken')){
				$gateway = Omnipay::create('Stripe');
				$gateway->setApiKey('sk_test_mpHOcobqO3PW98fMEcZb0cpA');
				$token = Input::get('stripeToken');
			
				$response = $gateway->purchase(['amount' => '10.00', 'currency' => 'USD', 'token' => $token])->send();
			if ($response->isSuccessful()) {
    // payment was successful: update database
    print_r($response);
} elseif ($response->isRedirect()) {
    // redirect to offsite payment gateway
    $response->redirect();
} else {
    // payment failed: display message to customer
    echo $response->getMessage();
}
		}
	}

	public function transaction()
	{

		if(Input::get('stripeToken')){
				$gateway = Omnipay::create('Stripe');
				$token = Input::get('stripeToken');
			
				$response = $gateway->purchase(['amount' => '10.00', 'currency' => 'USD', 'token' => $token])->send();
				print_r($response);
				dd('new transaction');
		}
		else{

			return View::make('payment.stripe');
		}
	
	}
	*/


function complete(){

	$gateway = Omnipay::create('PayPal_Express');
	$gateway->setUsername('simon_api1.webworx.co.uk');
	$gateway->setPassword('75V88J28C8H683AR');
	$gateway->setSignature('A6yvKsoDiK8zNqxKD4WTTVT8XadIAAaWNgwrKvo.fVzd3wmzuwAJQmqi');
		$token = Input::get('token');
	$response = $gateway->fetchCheckout(
                array(
                   'token' => $token,
                    )
            	)->send();

 	$data = $response->getData();
 $response = $gateway->completePurchase(
                    array(
                    	'token' => $data['TOKEN'],
        	            'amount' => 5.00,
                        'currency' => 'USD'
                    )
            )->send();
 	$data = $response->getData();
 	print_r($data);
 	
}
	function pay(){

		$gateway = Omnipay::create('PayPal_Express');


		echo $gateway->getShortName();
		print_r($gateway->getParameters());
		die();
 		$gateway->setUsername('simon_api1.webworx.co.uk');
 		$gateway->setPassword('75V88J28C8H683AR');
 		$gateway->setSignature('A6yvKsoDiK8zNqxKD4WTTVT8XadIAAaWNgwrKvo.fVzd3wmzuwAJQmqi');
		 $response = $gateway->authorize(
                    array(
                        'cancelUrl' => 'http://localhost:8000/orders/12/pay',
                        'cancelUrl' => 'http://localhost:8000/orders/12/pay',
                        'returnUrl' => 'http://localhost:8000/api/v1/orders/12/complete', 
                        'amount' => 0.50,
                        'currency' => 'USD'
                    )
            )->send();
 		$data = $response->getData();
 	
return Redirect::to('https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$data['TOKEN']);

 //print_r($response-);

//dd('boo');

 $data = $response->getData();


  $response = $gateway->completePurchase(
                    array(
                    	'token' => $data['TOKEN'],
        	            'cancelUrl' => '/pay/l',
                        'cancelUrl' => 'www.xyz.com/cancelurl',
                        'returnUrl' => 'www.xyz.com/returnurl', 
                        'amount' => 5.00,
                        'currency' => 'USD'
                    )
            )->send();


    $data = $response->getData(); // this is the raw response object
    echo '<pre>';
    print_r($data);

	}

	public function transaction()
	{
		

	
	}


}
