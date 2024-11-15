<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    protected $fillable = ['name', 'user_id'];

    protected static function booted()
    {
        static::creating(function ($typeDocument) {
            $typeDocument->name = strtoupper($typeDocument->name);
            $typeDocument->user_id = auth()->id();
            $typeDocument->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
