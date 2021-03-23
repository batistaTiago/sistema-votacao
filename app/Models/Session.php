<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public const AVAILABLE_FILTERS = [
        'session_status_id' => '=',
        'session_category_id' => '=',
        'datetime_start' => '>=',
        'datetime_end' => '<=',
    ];

    /* @TODO: subir para a super classe? */
    public static function findWithFilters(array $filters)
    {
        $query = self::query();

        foreach ($filters as $key => $value) {
            if (array_key_exists($key, self::AVAILABLE_FILTERS)) {
                $operator = self::AVAILABLE_FILTERS[$key];
                $query->where($key, $operator, $value);
            }
        }

        return $query->get();
    }
}
