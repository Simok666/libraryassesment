<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Komponen extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id'
    ];

    /**
     * Get the Komponen for the subkomponen.
     */
    public function subKomponens(): HasMany
    {
        return $this->hasMany(subKomponen::class, 'subkomponen_id', 'id');
    }
}
