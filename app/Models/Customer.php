<?php namespace OMS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @package OMS\Models
 */
class Customer extends Eloquent {

    use SoftDeletingTrait;

    /**
     * Database table for this model
     * @var string
     */
    protected $table = "customers";

    /**
     * Which fields of this model can be mass assigned through Customer::create()
     * @var array
     */
    protected $fillable = [
        'forename',
        'surname',
        'password',
        'surname',
        'company',
        'customer_type_id',
        'last_login',
        'opt_in',
        'shipping_address_id',
        'billing_address_id'
    ];

    /**
     * Define the additional dates that should be Carbon objects
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];


    /**
     * Concatenate the customers forename, and surname
     * @return string
     */
    public function getFullName() {
        return $this->forename . " " . $this->surname;
    }

    /**
     * A customer can have multiple orders
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('OMS\Models\Orders', 'customer_id');
    }

    /**
     * A customer can be of one type (foreign key dependency)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customerType()
    {
        return $this->belongsTo('OMS\Model\CustomerType', 'customer_type_id');
    }

    /**
     * A customer can have one billing address (foreign key dependency)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billingAddress()
    {
        return $this->belongsTo('OMS\Model\Address', 'billing_address_id');
    }

    /**
     * A customer can have one shipping address (foreign key dependency)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shippingAddress()
    {
        return $this->belongsTo('OMS\Model\Address', 'shipping_address_id');
    }

    /**
     * A customer can have multiple addresses
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('OMS\Model\Address');
    }
}
