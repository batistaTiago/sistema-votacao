<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        User::insert([
            [
                'name' => 'Margarete mergete',
                'email' => 'secretario@smartvote.com',
                'password' => Hash::make('senha123'),
                'user_category_id' => 2,
            ],
            [
                'name' => 'Eneas',
                'email' => 'deputado@smartvote.com',
                'password' => Hash::make('senha123'),
                'user_category_id' => 1,
            ],
            [
                'name' => 'Presidente Shinra',
                'email' => 'presidente@smartvote.com',
                'password' => Hash::make('senha123'),
                'user_category_id' => 3,
            ],

        ]);
    }
}
