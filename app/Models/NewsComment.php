<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'name',
        'email',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the news article this comment belongs to.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
