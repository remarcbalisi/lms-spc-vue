<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Remarc',
            'middle_name' => 'Espinosa',
            'last_name' => 'Balisi',
            'email' => 'remarc.balisi@gmail.com',
            'password' => bcrypt('admin'),
            'role_id' => 1
        ]);
    }
}
