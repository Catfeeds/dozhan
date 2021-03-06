<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ResourcesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(WorksTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(FavoursTableSeeder::class);
    }
}
