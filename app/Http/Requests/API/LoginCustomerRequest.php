<?php namespace OMS\Http\Requests\API;

class LoginCustomerRequest extends APIRequest
{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => 'required|email',
			//'password' => 'required|size:40'
		];
	}

}
