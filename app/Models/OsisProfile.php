<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsisProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabinet_name',
        'period',
        'tagline',
        'vision',
        'mission',
        'leader_name',
        'leader_welcome',
        'leader_photo',
        'cabinet_photo',
        'cabinet_logo',
        'instagram_url',
        'tiktok_url',
        'youtube_url',
    ];

    /**
     * Helper to get the single active profile singleton.
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'cabinet_name' => 'Kabinet Cakra Baskara',
            'period' => '2025/2026',
            'tagline' => 'Bersinergi, Berkarakter, Menginspirasi',
            'vision' => 'Mewujudkan OSIS SMAN 24 Bandung sebagai wadah aspirasi dan pengembangan potensi siswa yang berakhlak mulia, cerdas, kreatif, dan berwawasan global.',
            'mission' => "1. Menumbuhkan keimanan dan ketaqwaan kepada Tuhan YME.\n2. Mendorong prestasi akademik dan non-akademik siswa.\n3. Mengembangkan kreativitas dan jiwa kepemimpinan siswa.\n4. Menjalin hubungan harmonis antara siswa, guru, dan masyarakat.",
            'leader_name' => 'Muhammad Rizky Pratama',
            'leader_welcome' => 'Selamat datang di halaman resmi OSIS SMAN 24 Bandung. Mari bersama-sama berkarya dan berprestasi membawa nama harum almamater tercinta.',
            'instagram_url' => 'https://instagram.com/osis24bdg',
        ]);
    }
}
