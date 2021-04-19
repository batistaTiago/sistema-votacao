<?php

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentCategory::insert([
            ['name' => 'Projeto de lei do executivo'],
            ['name' => 'Projeto de lei do legislativo'],
        ]);
    }
}
