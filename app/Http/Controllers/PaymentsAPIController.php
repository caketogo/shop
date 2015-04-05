<?php namespace OMS\Http\Controllers;

use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Application\PaymentGateway\Gateway as Gateway;
#use OMS\Http\Requests\API\reateOrderRequest;
use OMS\Models\PaymentMethod as PaymentMethod;
use OMS\Models\Payment as Payment;
use OMS\Models\Order as Order;
use OMS\Models\OrderStatus as OrderStatus;

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


	public function view($order_id)
	{
		
		$order = Order::find($order_id);
		$amount = $order->amount * 100;
			$form ='
		<form action="" method="POST">
  		<script
    		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    		data-key="pk_test_lZESGr161LaJH9rTi0esWR8o"
    		data-amount="'.$amount.'"
    		data-name="Demo Site"
    		data-description="2 widgets ($20.00)"
    		data-image="/128x128.png">
  		</script>
		</form>
		';

		return Response::json($form);
	}




	public function purchase($order_id)
	{

		$token = Input::get('token');
		$order = Order::find($order_id);
		$payment = Payment::where('order_id',$order_id)->orderBy('updated_at','desc')->first();
	
		Omnipay::setGateway('stripe');
	    $response = Omnipay::purchase(['amount' =>  $order->amount, 'currency' => 'USD', 'token' => $token])->send();
	  
	    if ($response->isSuccessful()) {
    			// payment was successful: update database
    			$payment->payment_status_id = 1;

    	
			} elseif ($response->isRedirect()) {
    
				$payment->payment_status_id = 3;
    			//$response->redirect();
			} else {
    			// payment failed:  
    			//dd($response);
    			$payment->payment_status_id = 2;
    		
			}

		$payment->transaction_id = $response->getTransactionReference();

		if($payment->save()){

			$order->setStatus('Confirmed');
		}
		
		return Response::json(array('status' => $payment->payment_status_id));

	}

	public function pay($order_id)
	{


		$payment = new Payment;
		$order = Order::find($order_id);
		$payment->order_id = $order_id;
	

		$order->setStatus('Payment');
		
		
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
		$order = Order::find($order_id);

		$payment->payment_method_id = Input::get('payment_method_id');
		$payment->order_id = $order_id;
		if($payment->save()){

			$order->setStatus('Payment');
		}

		
		return Response::json($payment);
	}

}
