<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EselonDua extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_eselon_satu',
        'nama_satuan_kerja_eselon_2'
    ];

    /**
     * Get the user that owns the eselon satu.
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id_satuan_kerja_eselon_2');
    }

    /**
     * belongs to eselon
     */
    public function eselon(): BelongsTo
    {
        return $this->belongsTo(EselonSatu::class, 'id_eselon_satu');
    }

    /**
     * Get the eselon 3 that owns the Eselon 2.
     */
    public function eselons_tiga(): HasMany
    {
        return $this->hasMany(EselonTiga::class, 'id_eselon_dua');
    }
}
