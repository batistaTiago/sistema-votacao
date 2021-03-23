<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $guarded = [];

    public const DEFAULT_DISK = 'public';
    public const DEFAULT_SAVE_PATH = 'documents';

    public const AVAILABLE_FILTERS = [
        'document_status_id' => '=',
        'document_category_id' => '=',
    ];

    public static function storeFile($file): string
    {
        $name = $file->name ?? $file->getClientOriginalName();
        $storageUrl = Storage::disk(self::DEFAULT_DISK)->putFileAs(self::DEFAULT_SAVE_PATH, $file, $name);
        return asset('storage/' . $storageUrl);
    }

    public static function findWithFilters(array $filters)
    {

        $document_ids = DocumentSession::select('document_id')
            ->where('session_id', $filters['session_id'])
            ->get()
            ->pluck('document_id');

        $query = self::query()->whereIn('id', $document_ids);

        foreach ($filters as $key => $value) {
            if (array_key_exists($key, self::AVAILABLE_FILTERS)) {
                $operator = self::AVAILABLE_FILTERS[$key];
                $query->where($key, $operator, $value);
            }
        }

        return $query->get();
    }
}
