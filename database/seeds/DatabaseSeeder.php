<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserCategorySeeder::class);

        $this->call(DocumentStatusSeeder::class);
        $this->call(DocumentCategorySeeder::class);

        $this->call(SessionStatusSeeder::class);
    }
}
