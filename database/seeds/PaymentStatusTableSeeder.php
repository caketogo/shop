<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use OMS\Models\PaymentStatuses as PaymentStatus;
class PaymentStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('payment_statuses')->delete();

        PaymentStatus::create(['id' => 1,'name' => 'Pending','description' => 'Payment is registered.']);
        PaymentStatus::create(['id' => 2,'name' => 'Confirmed','description' => 'Payment has been made.']);
        PaymentStatus::create(['id' => 3,'name' => 'Failed','description' => 'Payment for the order was attempted but failed for some reason']);
        PaymentStatus::create(['id' => 4,'name' => 'Redirect','description' => 'The customer has been redirected to a remote payment page']);
        	
        
    }

}

?>