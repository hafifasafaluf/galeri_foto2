<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Album;
use App\Models\User;
use App\Models\KomentarFoto;
use App\Models\LikeFoto;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';
    protected $primaryKey = 'FotoID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'JudulFoto',
        'DeskripsiFoto',
        'TanggalUnggah',
        'LokasiFile',
        'AlbumID',
        'UserID',
    ];

    protected $casts = [
        'TanggalUnggah' => 'date',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class, 'AlbumID', 'AlbumID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarFoto::class, 'FotoID', 'FotoID');
    }

    public function likes()
    {
        return $this->hasMany(LikeFoto::class, 'FotoID', 'FotoID');
    }
}
