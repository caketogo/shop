<?php namespace OMS\Models;

use Eloquent;

class OrderStatus extends Eloquent
{

    /**
     * @var string
     */
	protected $table = 'order_statuses';

    /**
     * @var array
     */
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('OMS\Models\Order', 'order_statuses_id');
    }

}
