<?php namespace OMS\Http\Requests\API;

class CreateOrderRequest extends FormRequest {

    protected $isJson = true;

    /**
     * The rules that this request must adhere to
     * @return array
     */
    public function rules()
    {
        return [
            'order_statuses_id' => 'exists:order_statuses,id',
            'ip' => 'ip',
            'customer_id' => 'max:11|exists:customers,id',
            'billing_address_id' => 'max:11|exists:addresses,id',
            'shipping_address_id' => 'max:11|exists:addresses,id'
        ];
    }

    /**
     * At this point we don't want any authorization logic (as this will be handled by OAuth)
     *   so we will simply return true
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}