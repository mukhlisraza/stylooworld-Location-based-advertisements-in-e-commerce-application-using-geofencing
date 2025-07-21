<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $deliveryRecords = [
            ['id' => 1, 'user_id' => 1, 'name' => 'Ali', 'address' => 'Test 123', 'city' => 'Rawalpindi', 'country' => 'Pakistan', 'pincode' => '26300', 'mobile' => '03025496045', 'status' => 1],
            ['id' => 2, 'user_id' => 14, 'name' => 'Qasim', 'address' => 'Test 135', 'city' => 'Islamabad', 'country' => 'Pakistan', 'pincode' => '36300', 'mobile' => '03025496045', 'status' => 1],
        ];

        DeliveryAddress::insert($deliveryRecords);
    }
}
