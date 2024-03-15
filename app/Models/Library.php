<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Library extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nomor_npp',
        'hasil_akreditasi',
        'nama_perpustakaan',
        'alamat',
        'desa',
        'kabupaten_kota',
        'provinsi',
        'no_telp',
        'situs_web',
        'email',
        'status_kelembagaan',
        'tahun_berdiri_perpustakaan',
        'sk_pendirian_perpustakaan',
        'nama_kepala_perpustakaan',
        'nama_kepala_instansi',
        'induk',
        'visi',
        'misi',
    ];

    /**
     * Get the user that owns the library.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
