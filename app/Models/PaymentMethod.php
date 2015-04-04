<?php namespace OMS\Models;

use Eloquent;

class PaymentMethod extends Eloquent
{

    /**
     * @var string
     */
	//protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = [];

    /*
    public function orderStatus()
    {
        return $this->belongsTo('OMS\Models\OrderStatus', 'order_statuses_id');
    }

    public function customer()
    {
        return $this->belongsTo('OMS\Models\Customer', 'customer_id');
    }
    */

}