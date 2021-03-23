<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    public const DOC_STATUS_AGUARDANDO_VOTACAO = 1;
    public const DOC_STATUS_EM_VOTACAO = 2;
    public const DOC_STATUS_VISTA = 3;
    public const DOC_STATUS_VOTACAO_CONCLUIDA = 4;
}
