<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OMS\Models\OrderStatus as OrderStatus;
class OrderStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('order_statuses')->delete();

        OrderStatus::create(['id' => 1,'name' => 'Shopping','description' => 'Order in progress customer is shopping.']);
        OrderStatus::create(['id' => 2,'name' => 'Registering','description' => 'Customer is registering.']);
        OrderStatus::create(['id' => 3,'name' => 'Checkout','description' => 'Customer is currently at the checkout.']);
        OrderStatus::create(['id' => 4,'name' => 'Login','description' => 'Customer is currently at login']);
        OrderStatus::create(['id' => 5,'name' => 'Payment','description' => 'Customer is at payment page.']);
        OrderStatus::create(['id' => 6,'name' => 'Remote Payment','description' => 'Customer is currently at payment gateway.']);
        OrderStatus::create(['id' => 7,'name' => 'Failed Payment','description' => 'Customers payment failed for some reason']);
        OrderStatus::create(['id' => 8,'name' => 'Confirmed','description' => 'Customer paid and order confirmed.']);
        OrderStatus::create(['id' => 9,'name' => 'Complete','description' => 'Order is complete and it has been despatched to customer']);
        OrderStatus::create(['id' => 10,'name' => 'Partially Refunded','description' => 'Customers order has been partially refunded.']);
        OrderStatus::create(['id' => 11,'name' => 'Refunded','description' => 'Customers order has been fully refunded']);
        OrderStatus::create(['id' => 12,'name' => 'On Hold','description' => 'Customers order is on hold for some reason.']);
        OrderStatus::create(['id' => 13,'name' => 'Disputed','description' => 'Customer has initiated a dispute with the order']);
        	
        
    }

}

?>