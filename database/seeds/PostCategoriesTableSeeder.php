<?php

use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_categories')->insert([
            'name' => 'Announcement',
            'slug' => 'announcement',
        ]);

        DB::table('post_categories')->insert([
            'name' => 'News',
            'slug' => 'news',
        ]);

        DB::table('post_categories')->insert([
            'name' => 'General',
            'slug' => 'general',
        ]);
    }
}
