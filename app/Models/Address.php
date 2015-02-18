<?php namespace OMS\Models;
use Eloquent;
class Address extends Eloquent {

   // use SoftDeletingTrait;

    protected $table = "addresses";

    protected $fillable = [
        'name',
        'forename',
        'surname',
        'company',
        'address',
        'address2',
        'city',
        'postcode',
        'country_id',
        'county',
        'customer_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

}