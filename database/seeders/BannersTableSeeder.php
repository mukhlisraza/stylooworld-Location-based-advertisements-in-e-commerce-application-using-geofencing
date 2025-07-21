<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bannerRecords = [
            ['id' => 1, 'image' => 'banner1.jpg', 'link' => '', 'title' => 'Available Near Your Heart', 'description' => 'Smart Style Have Smart Decision', 'alt' => '', 'status' => 1],
            ['id' => 2, 'image' => 'banner2.jpg', 'link' => '', 'title' => '90% Sale Available', 'description' => "Hurraaa! Don't Waste Time. Get to Avail Discount", 'alt' => '', 'status' => 1],
            ['id' => 3, 'image' => 'banner3.jpg', 'link' => '', 'title' => 'First Time Using Geofencing', 'description' => 'Smart Style Have Smart Decision', 'alt' => '', 'status' => 1],
        ];

        Banner::insert($bannerRecords);
    }
}
