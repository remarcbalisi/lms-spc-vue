<?php

use Illuminate\Database\Seeder;

class PostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_types')->insert([
            'name' => 'School Wide',
            'slug' => 'school-wide',
        ]);

        DB::table('post_types')->insert([
            'name' => 'Classroom',
            'slug' => 'classroom',
        ]);
    }
}
