<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Album;
use App\Models\Foto;
use App\Models\LikeFoto;
use App\Models\KomentarFoto;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'UserID';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'NamaLengkap',
        'Alamat',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'UserID', 'UserID');
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'UserID', 'UserID');
    }

    public function likes()
    {
        return $this->hasMany(LikeFoto::class, 'UserID', 'UserID');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarFoto::class, 'UserID', 'UserID');
    }
}
