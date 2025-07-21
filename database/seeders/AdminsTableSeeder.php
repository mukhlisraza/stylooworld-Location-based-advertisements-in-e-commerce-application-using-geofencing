<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id' => 1, 'fname' => 'saqlain', 'lname' => 'abbas', 'type' => 'admin', 'mobile' => '+923025496045', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin123'), 'image' => '', 'status' => 1],
            ['id' => 2, 'fname' => 'ahmad', 'lname' => 'faraz', 'type' => 'vendor', 'mobile' => '+923023212234', 'email' => 'ahmad@gmail.com', 'password' => bcrypt('ahmad123'), 'image' => '', 'status' => 1],
        ];

        DB::table('admins')->insert($adminRecords);

        // foreach ($adminRecords as $key  => $record) {
        //     \App\Admin::create($record);
        // }

    }
}
