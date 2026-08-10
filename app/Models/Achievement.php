<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'level',
        'winner_name',
        'event_name',
        'achievement_year',
        'description',
        'photo',
    ];

    protected $casts = [
        'achievement_year' => 'integer',
    ];
}
