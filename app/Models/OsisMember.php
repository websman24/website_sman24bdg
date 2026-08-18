<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsisMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'department',
        'class_grade',
        'photo',
        'instagram',
        'motto',
        'order_position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_position' => 'integer',
    ];

    /**
     * Map of department codes to readable labels.
     */
    public const DEPARTMENTS = [
        'bph' => 'Badan Pengurus Harian (BPH)',
        'sekbid_1' => 'Sekbid 1 - Ketaqwaan & Keagamaan',
        'sekbid_2' => 'Sekbid 2 - Budi Pekerti & Karakter',
        'sekbid_3' => 'Sekbid 3 - Kepemimpinan & Bela Negara',
        'sekbid_4' => 'Sekbid 4 - Prestasi Akademik, Seni & Olahraga',
        'sekbid_5' => 'Sekbid 5 - Demokrasi & Lingkungan Hidup',
        'sekbid_6' => 'Sekbid 6 - Kreativitas & Kewirausahaan',
        'sekbid_7' => 'Sekbid 7 - Kebugaran Jasmani & Kesehatan',
        'sekbid_8' => 'Sekbid 8 - Sastra, Bahasa & Budaya',
        'sekbid_9' => 'Sekbid 9 - Teknologi Informasi & Medkref',
        'sekbid_10' => 'Sekbid 10 - Bahasa Asing & Humas',
        'mpk' => 'Majelis Perwakilan Kelas (MPK)',
    ];

    /**
     * Get the readable department name.
     */
    public function getDepartmentLabelAttribute(): string
    {
        return self::DEPARTMENTS[$this->department] ?? ucfirst($this->department);
    }
}
