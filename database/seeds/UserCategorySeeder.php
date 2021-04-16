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
                'name' => 'Secretario'
            ],
            [
                'name' => 'Deputado'
            ],
            [
                'name' => 'Vereador'
            ],
            [
                'name' => 'Presidente'
            ],
            [
                'name' => 'Admin'
            ],
        ]);
    }
}
