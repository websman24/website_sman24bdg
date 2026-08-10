<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'mentor_name',
        'schedule',
        'description',
        'logo_or_photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
