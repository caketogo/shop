<?php namespace OMS\Models;

use Eloquent;

class OrderItem extends Eloquent
{

    /**
     * @var string
     */
	protected $table = 'order_items';

    /**
     * @var array
     */
    protected $guarded = [];

    public function hello(){
        dd('hello');
    }

    public function order()
    {
        return $this->belongsTo('OMS\Models\Order', 'order_id');
    }


}