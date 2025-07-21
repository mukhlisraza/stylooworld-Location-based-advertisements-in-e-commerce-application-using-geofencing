<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $brandRecords = [
            ['id' => 1, 'name' => 'Khaddar', 'status' => 1],
            ['id' => 2, 'name' => 'Linen', 'status' => 1],
            ['id' => 3, 'name' => 'Velvet', 'status' => 1],
        ];
        Brand::insert($brandRecords);
    }
}
