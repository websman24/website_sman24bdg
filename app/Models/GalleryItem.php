<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image_path',
        'caption',
        'order_position',
    ];

    protected $casts = [
        'order_position' => 'integer',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
