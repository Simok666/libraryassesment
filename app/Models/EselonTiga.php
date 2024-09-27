<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EselonTiga extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_eselon_dua',
        'nama_satuan_kerja_eselon_3'
    ];

    /**
     * Get the user that owns the eselon satu.
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id_satuan_kerja_eselon_3');
    }
    
    /**
     * belongs to eselon 2
     */
    public function eselons_dua(): BelongsTo
    {
        return $this->belongsTo(EselonDua::class, 'id_eselon_dua');
    }

    /**
     * Get the fungsi that owns the Eselon 3.
     */
    public function fungsi(): HasMany
    {
        return $this->hasMany(Fungsi::class, 'id_eselon_tiga');
    }
}
