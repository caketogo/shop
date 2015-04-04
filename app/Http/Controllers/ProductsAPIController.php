<?php namespace OMS\Http\Controllers;

use OMS\Http\Requests;
use OMS\Http\Controllers\Controller;
use Illuminate\Http\Request;

use OMS\Http\Requests\API\CreateOrderRequest;
use OMS\Models\Product as Product;


use Response;
use Schema;
use Input;


class ProductsAPIController extends ApiController {

	var $site_id = 1;

	public function test()
	{
		//$columns = Schema::getColumnListing('products'); // users table
		//dd($columns);
		//
		//
		//
		
		//create a new product
		$product = new Product;

		//populate the product
		$product->name = 'My Product';
		$product->brand = 'My Brand';
		$product->sku = 'MYSKU';
		$product->title ='The title of my super product';
		$product->description = "My Product is a very nice product. It is a good price and is supplied by the best known brand. It is available to purchase now.";
		$product->image = '/img/image.jpg';
		$product->image_thumb = '/img/image_thumb.jpg';
		$product->lead_time = 5;
		$product->price = 9.99;
		$product->cost = 3.99;
		//save the product
		if($product->save()){

			//now associate with site
			dd($product);
			
		}
		/*
		array:18 [▼
  0 => "id"
  1 => "brand"
  2 => "name"
  3 => "sku"
  4 => "stock_status_id"
  5 => "description"
  6 => "image"
  7 => "image_thumb"
  8 => "keywords"
  9 => "slug"
  10 => "short_name"
  11 => "sort_order"
  12 => "lead_time"
  13 => "price"
  14 => "cost"
  15 => "created_at"
  16 => "deleted_at"
  17 => "updated_at"
]
*/

	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::all();
		return Response::json($products);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$product = new Product;
		$product->name = Input::get('name');
		$product->save();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$products = Product::find($id);
		return Response::json($products);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
