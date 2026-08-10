<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'nip',
        'name',
        'position',
        'gender',
        'photo',
        'email',
        'phone',
        'order_position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_position' => 'integer',
    ];
}
