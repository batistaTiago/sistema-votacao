<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    public const SECRETARIO = 1;
    public const DEPUTADO = 2;
    public const VEREADOR = 3;
    public const PRESIDENTE = 4;
    public const ADMIN = 5;

}
