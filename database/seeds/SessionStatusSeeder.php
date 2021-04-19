<?php

use App\Models\SessionStatus;
use Illuminate\Database\Seeder;

class SessionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SessionStatus::insert([
            [
                'id' => SessionStatus::SESSION_STATUS_AGUARDANDO_VOTACAO,
                'name' => 'Aguardando votacao'
            ],
            [
                'id' => SessionStatus::SESSION_STATUS_EM_VOTACAO,
                'name' => 'Em votacao'
            ],
            [
                'id' => SessionStatus::SESSION_STATUS_CONCLUIDA,
                'name' => 'Concluida'
            ],
        ]);
    }
}
