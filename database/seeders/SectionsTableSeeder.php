<?php

use Illuminate\Database\Seeder;
use App\Section; //calling section model

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create variable [array] and inside store data

        $sectionRecords = [
            ['id' => 1, 'name' => 'Men', 'status' => 1],
            ['id' => 2, 'name' => 'Women', 'status' => 1],
            ['id' => 3, 'name' => 'Kids', 'status' => 1],
        ];

        //Now insert the data into section model
        Section::insert($sectionRecords);
    }
}
