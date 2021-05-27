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
        'name' => '=',
        'id' => '=',
    ];

    public function sessions()
    {
        return $this->belongsToMany(Session::class, DocumentSession::class);
    }
    
    public function document_status()
    {
        return $this->belongsTo(DocumentStatus::class);
    }

    /* refatorar */
    public static function storeFile($file): string
    {
        $name = $file->name ?? $file->getClientOriginalName();
        $storageUrl = Storage::disk(self::DEFAULT_DISK)->putFileAs(self::DEFAULT_SAVE_PATH, $file, $name);
        return asset('storage/' . $storageUrl);
    }

    public static function findWithFilters(array $filters)
    {
        if (isset($filters['session_id'])) {
            $document_ids = DocumentSession::select('document_id')
                ->where('session_id', $filters['session_id'])
                ->get()
                ->pluck('document_id');
        }

        $query = self::query();

        if (!empty($document_ids)) {
            $query->whereIn('id', $document_ids);
        }

        foreach ($filters as $key => $value) {
            if (array_key_exists($key, self::AVAILABLE_FILTERS)) {
                $operator = self::AVAILABLE_FILTERS[$key];
                $query->where($key, $operator, $value);
            }
        }

        return $query->get();
    }

    public function attachToSession(Session $session)
    {
        return DocumentSession::attachDocumentToSession($this, $session);
    }

    public function detachFromSession(Session $session)
    {
        return DocumentSession::detachDocumentFromSession($this, $session);
    }
}
