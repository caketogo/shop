<?php namespace OMS\Models;

use Eloquent;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;



class Product extends Eloquent implements SluggableInterface
{


      use SluggableTrait;

        protected $sluggable = array(
            'build_from' => 'title',
            'save_to'    => 'slug',
        );

    /**
     * @var string
     */
	protected $table = 'products';

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
   


   public function add()
   {

   dd('adding');

   }

}