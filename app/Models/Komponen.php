<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komponen extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;




    /**
     * Get the user that owns the komponen.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
