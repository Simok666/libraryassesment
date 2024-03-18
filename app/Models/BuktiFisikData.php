<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuktiFisikData extends Model
{
    use HasFactory;

    /**
     * Get the Komponen for the subkomponen.
     */
    public function buktiFisik(): HasMany
    {
        return $this->hasMany(BuktiFisik::class);
    }
}
