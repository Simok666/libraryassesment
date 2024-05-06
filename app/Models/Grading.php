<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grade',
        'details',
    ];

    /**
     * Get the user that owns the grade.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'grade', 'grade');
    }

}
