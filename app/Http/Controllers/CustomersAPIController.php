<?php namespace OMS\Http\Controllers;


use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use OMS\Http\Requests\API\CreateCustomerRequest;
use OMS\Http\Requests\API\LoginCustomerRequest;
use OMS\Http\Requests\API\CreateAddressRequest;
use OMS\Models\Customer as Customer;
use OMS\Models\Address as Address;


use Illuminate\Http\Request;
use Response;
use Input;
use Carbon\Carbon;

class CustomersAPIController extends ApiController {

	/**
	 * Return all of the resources in the OMS. This will be paginated and return the most recent 20 by default.
	 *
	 * @return Response
	 */
	public function index()
	{

		
		$orders = Customer::all();

		dd($orders);
	}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

        $customer = Customer::find($id);
    
        return Response::json($customer);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(CreateCustomerRequest $request)
	{

		//dd(Input::all());
		$customer = new Customer;

		// Set the email
        $customer->email = Input::get('email');

        // Set the pwd
        $customer->password = Input::get('password');

        // Name
        $customer->forename = Input::get('forename');
        $customer->surname = Input::get('surname');

        // Marketing opt in
        $customer->opt_in = Input::get('opt_in');

        // Customer Type
        if(Input::has('customer_type_id')) {
        	 $customerType = CustomerType::find(Input::get('customer_type_id'));
        	$customer->customerType()->associate($customerType);
        }
       

        // Company (optional)
        if(Input::has('company')) {
            $customer->company = Input::get('customer');
        }

        // Shipping Address
        if(Input::has('shipping_address_id')) {
            $address = Address::find('shipping_address_id');
            $customer->shippingAddress()->associate($address);
        }

        // Billing Address
        if(Input::has('billing_address_id')) {
            $address = Address::find('billing_address_id');
            $customer->billingAddress()->associate($address);
        }

        // Save the customer
        $customer->save();

        // Set the response code
        $this->setStatusCode(200);

		// Return the response, with the order, as JSON
		return Response::json($customer);
	}

	
    /**
     * Check if a login is correct and return the customer entity
     *
     * @param $username
     * @param $password
     */
    public function login(LoginCustomerRequest $request)
    {
        $customer = $c = Customer::where('email', Input::get('email'))
                            ->where('password', Input::get('password'))
                            ->first();


        if ( ! $customer ) {
            // Set the status code to 401 (Unauthorized)
            $this->setStatusCode(401);

            // Return error
            return $this->respondWithError([
                "That username and password was not found on the system."
            ]);
        }

        // Set the default response code
        $this->setStatusCode(200);

        // Update the last login time
        $c->last_login = Carbon::now();
        $c->save();

        // Return the customer object
        return $this->respond([
            'login' => true,
            'data' => $customer
        ]);
    }

	/**
	 * create a new address.
	 *
	 * @return Response
	 */
	public function create_address(CreateAddressRequest $request)
	{

		
		$address = new Address;
		$address->customer_id = Input::get('customer_id');
		
        // Name
        $address->name = Input::get('name');
        $address->forename = Input::get('forename');
        $address->surname = Input::get('surname');

        // Address
      	$address->address = Input::get('address');
      	$address->address2 = Input::get('address2');
      	$address->city = Input::get('city');
      	$address->county = Input::get('county');
      	$address->postcode = Input::get('postcode');

      	/*
      	* if we only have a single address
      	* should we make this the default?
      	*/
        

        // Company (optional)
        if(Input::has('company')) {
            $address->company = Input::get('customer');
        }

        // Shipping Address
        if(Input::has('shipping_address_id')) {
            $address = Address::find('shipping_address_id');
            $customer->shippingAddress()->associate($address);
        }

        // Billing Address
        if(Input::has('billing_address_id')) {
            $address = Address::find('billing_address_id');
            $customer->billingAddress()->associate($address);
        }

        // Save the address
        $address->save();

        // Set the response code
        $this->setStatusCode(200);

		// Return the response, with the address, as JSON
		return Response::json($address);
	}

	/**
	 * list all customer addresses
	 *
	 * @return Response
	 */
	public function index_address($id)
	{
	
		$addresses = Address::all()->where('customer_id',$id);
		return Response::json($addresses);

	}




}
