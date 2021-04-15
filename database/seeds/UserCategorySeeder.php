<?php

use App\Models\UserCategory;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCategory::insert([
            [
                'name' => 'Secretario (a)'
            ],
            [
                'name' => 'Secretario (a)'
            ],
            [
                'name' => 'Secretario (a)'
            ],
        ]);
    }
}
