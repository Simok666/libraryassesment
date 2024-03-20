<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKomponen extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subkomponen_id',
        'skor_subkomponen',
        'nilai',
        'is_verified',
    ];

    /**
     * Get the subkomponen that owns the komponen.
     */
    public function komponen(): BelongsTo
    {
        return $this->belongsTo(Komponen::class, 'subkomponen_id', 'id');
    }

    /**
     * Get the user that owns the komponen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
