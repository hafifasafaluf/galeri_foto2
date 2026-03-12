<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Foto;

class Album extends Model
{
    use HasFactory;

    protected $table = 'album';
    protected $primaryKey = 'AlbumID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'NamaAlbum',
        'Deskripsi',
        'TanggalDibuat',
        'UserID',
    ];

    protected $casts = [
        'TanggalDibuat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'AlbumID', 'AlbumID');
    }
}
