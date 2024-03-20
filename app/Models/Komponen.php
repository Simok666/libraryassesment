<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komponen extends Model
{
    use HasFactory;

    /**
     * Get the Komponen for the subkomponen.
     */
    public function subKomponens(): HasMany
    {
        return $this->hasMany(subKomponen::class, 'subkomponen_id', 'id');
    }
}
