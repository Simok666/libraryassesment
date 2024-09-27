<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fungsi extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_eselon_tiga',
        'nama_fungsi'
    ];

    /**
     * Get the user that owns the eselon satu.
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'id_fungsi');
    }
    /**
     * belongs to eselon 3
     */
    public function eselons_tiga(): BelongsTo
    {
        return $this->belongsTo(EselonTiga::class, 'id_eselon_tiga');
    }
}
