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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'type_insert',
        'status_perpustakaan',
        'grade',
        'is_upload_google_form',
        'id_satuan_kerja_eselon_1',
        'id_satuan_kerja_eselon_2',
        'id_satuan_kerja_eselon_3',
        'id_fungsi'
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
     * Get the customer Evaluation associated with the user.
     */
    public function evaluation(): HasOne
    {
        return $this->hasOne(Evaluation::class, 'user_id', 'id');
    }

    /**
     * Get the grading associated with the user.
     */
    public function grading(): HasOne
    {
        return $this->hasOne(Grading::class, 'grade', 'grade');
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

    public function eselon_satu(): BelongsTo {
        return $this->belongsTo(EselonSatu::class, 'id_satuan_kerja_eselon_1');
    }
    
    public function eselon_dua(): BelongsTo {
        return $this->belongsTo(EselonDua::class, 'id_satuan_kerja_eselon_2');
    }
    
    public function eselon_tiga(): BelongsTo {
        return $this->belongsTo(EselonTiga::class, 'id_satuan_kerja_eselon_3');
    }

    public function fungsi(): BelongsTo {
        return $this->belongsTo(Fungsi::class, 'id_fungsi');
    }
}
