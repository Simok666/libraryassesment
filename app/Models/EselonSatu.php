<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EselonSatu extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_satuan_kerja_eselon_1'
    ];

    /**
     * Get the user that owns the eselon satu.
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id_satuan_kerja_eselon_1');
    }

    /**
     * Get the eselon 2 that owns the Eselon.
     */
    public function eselons_dua(): HasMany
    {
        return $this->hasMany(EselonDua::class, 'id_eselon_satu');
    }
}
