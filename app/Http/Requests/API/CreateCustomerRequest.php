<?php namespace OMS\Http\Requests\API;

class CreateCustomerRequest extends APIRequest
{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			// An email must be unique against customers.email,
			'email' => 'required|email|unique:customers,email',

			// A password should be sent as sha1 (40 chars)
			//'password' => 'required|size:40',

			// These lengths match the db
			'forename' => 'required|max:30',
			'surname' => 'required|max:30',
			'company' => 'max:40',

			// The site should decide what its customers are
			//'customer_type_id' => 'required|exists:customer_types,id',

			// Marketing opt in
			//'opt_in' => 'required|boolean',

			// These probably won't be passed at this stage
			//'shipping_address_id' => 'exists:addresses,id',
			//'billing_address_id' => 'exists:addresses,id'
		];
	}

}
