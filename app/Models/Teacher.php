<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'title_prefix',
        'title_suffix',
        'subject',
        'gender',
        'photo',
        'email',
        'phone',
        'education',
        'order_position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_position' => 'integer',
    ];

    /**
     * Get full name with titles.
     */
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([$this->title_prefix, $this->name, $this->title_suffix]);

        return implode(' ', $parts);
    }
}
