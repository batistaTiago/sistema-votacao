<?php

use App\Models\DocumentStatus;
use Illuminate\Database\Seeder;

class DocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentStatus::insert([
            [
                'id' => DocumentStatus::DOC_STATUS_CRIADO,
                'name' => 'Aguardando votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_AGUARDANDO_VOTACAO,
                'name' => 'Aguardando votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_EM_VOTACAO,
                'name' => 'Em votacao',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_VISTA,
                'name' => 'Em vista',
            ],
            [
                'id' => DocumentStatus::DOC_STATUS_VOTACAO_CONCLUIDA,
                'name' => 'Votacao Concluida',
            ],
        ]);
    }
}
