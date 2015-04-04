<?php namespace OMS\Http\Controllers;

use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Application\PaymentGateway\Gateway as Gateway;
#use OMS\Http\Requests\API\reateOrderRequest;
use OMS\Models\PaymentMethod as PaymentMethod;
use OMS\Models\Payment as Payment;
use OMS\Models\Order as Order;

use Response;
use Input;
use Omnipay;

class PaymentsAPIController extends ApiController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$products = Product::all();
		return Response::json($products);
	}

	/**
	 * return a list of payment methods.
	 * @return [type] [description]
	 */
	public function  methods()
	{
		//$gw = new Gateway;
		$methods = PaymentMethod::all();
		return Response::json($methods);
	}


	public function pay($order_id)
	{
		
		$payment = new Payment;
		$order = Order::find($order_id);

		$payment->order_id = $order_id;

		Omnipay::setGateway('stripe');
		
		$cardInput = [
    		'number'      => '4242424242424242',
    		'firstName'   => 'MR Simon Bridgewater',
    		'expiryMonth' => '03',
    		'expiryYear'  => '16',
    		'cvv'         => '333',
		];
		
		$card = Omnipay::creditCard($cardInput);
		
		$response = Omnipay::purchase([
    		'amount'    => $order->amount,
    		'card'      => $cardInput,
    		'returnUrl' => 'localhost',
    		'cancelUrl' => 'localhost',
    		'transactionId'=> $order_id
		])->send();
	
		//stripe id =2
		$payment->payment_method_id = 2;

		try{

			if ($response->isSuccessful()) {
    			// payment was successful: update database
    			$payment->payment_status_id = 1;
    	
			} elseif ($response->isRedirect()) {
    
				$payment->payment_status_id = 3;
    			$response->redirect();
			} else {
    			// payment failed:  
    			dd($response);
    			$payment->payment_status_id = 2;
    		
			}
		} catch(\Exception $e){

			dd($e->getMessage());


		}


		$payment->transaction_id = $response->getTransactionReference();
		$payment->save();
		
		return array('status' => $payment->payment_status_id);


	}



	/**
	 * create a new payment.
	 *
	 * @return Response
	 */
	public function create($order_id)
	{
		$payment = new Payment;
		$payment->payment_method_id = Input::get('payment_method_id');
		$payment->order_id = $order_id;
		$payment->save();

		
		return Response::json($payment);
	}

}
