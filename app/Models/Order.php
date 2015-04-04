<?php namespace OMS\Models;

use Eloquent;

class Order extends Eloquent
{

    /**
     * @var string
     */
	protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = [];


    public function orderStatus()
    {
        return $this->belongsTo('OMS\Models\OrderStatus', 'order_statuses_id');
    }

    public function customer()
    {
        return $this->belongsTo('OMS\Models\Customer', 'customer_id');
    }
   public function orderItem()
    {
        return $this->hasMany('OMS\Models\OrderItem', 'order_id');
    }



    public function deleteItem()
    {

        $this->OrderItem()->delete();
        $this->sync();
    }

    /*
    * syncronise the order by updating the cost etc.
    */
    public function sync()
    {
       

        $items=  $this->orderItem;
       
        $this->amount = 0;
        $this->total_items = 0;
        foreach($items as $item){
            $this->amount+= $item->price;
            $this->total_items+= $item->quantity;
            

        }
        $this->save();

     
    }

}