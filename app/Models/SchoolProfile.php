<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'image_path',
        'meta_json',
        'is_published',
    ];

    protected $casts = [
        'meta_json' => 'array',
        'is_published' => 'boolean',
    ];
}
