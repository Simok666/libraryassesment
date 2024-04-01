<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'instance_name',
        'pic_name',
        'leader_instance_name', 
        'library_name', 
        'head_library_name', 
        'npp', 
        'address',
        'map_coordinates',
        'village',
        'subdistrict',
        'city',
        'province',
        'website',
        'number_telephone',
        'library_email',
        'type_insert'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the customer library associated with the user.
     */
    public function library(): HasOne
    {
        return $this->hasOne(Library::class, 'user_id', 'id');
    }

    /**
     * Get the customer pleno associated with the user.
     */
    public function pleno(): HasOne
    {
        return $this->hasOne(Pleno::class, 'user_id', 'id');
    }

    /**
     * Get the customer komponen associated with the user.
     */
    public function komponen(): HasMany
    {
        return $this->hasMany(SubKomponen::class, 'user_id');
    }

    /**
     * Get the customer buktiFisik associated with the user.
     */
    public function buktiFisik(): HasMany
    {
        return $this->HasMany(BuktiFisik::class, 'user_id', 'id');
    }
}
