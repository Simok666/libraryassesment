<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiFisik extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'bukti_fisik_data_id',
    ];

    /**
     * Get the subkomponen that owns the komponen.
     */
    public function buktiFisikData(): BelongsTo
    {
        return $this->belongsTo(BuktiFisikData::class);
    }

    /**
     * Get the user that owns the komponen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
