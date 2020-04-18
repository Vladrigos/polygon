<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    //главный файл управляющий сидерами
    //php artisan db::seeder
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        //100 постов создаём
        factory(\App\Models\BlogPost::class, 100)->create();
    }
}
