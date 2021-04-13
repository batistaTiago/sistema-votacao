<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    public const DOC_STATUS_CRIADO = 1;
    public const DOC_STATUS_AGUARDANDO_VOTACAO = 2;
    public const DOC_STATUS_EM_VOTACAO = 3;
    public const DOC_STATUS_VISTA = 4;
    public const DOC_STATUS_EM_ANALISE_COMISSAO = 5;
    public const DOC_STATUS_VOTACAO_CONCLUIDA = 6;
}
