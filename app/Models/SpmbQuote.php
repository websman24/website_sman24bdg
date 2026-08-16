<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpmbQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_text',
        'author_source',
        'is_active',
        'order_position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_position' => 'integer',
    ];
}
