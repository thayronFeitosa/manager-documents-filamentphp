<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'typeDocumentId',
        'descriptions',
        'dateOfPayment',
        'dueDate',
        'value',
        'document'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'typeDocumentId');
    }

    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class, 'typeDocumentId');
    }

    protected static function booted()
    {
        static::creating(function ($Document) {
            $Document->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
