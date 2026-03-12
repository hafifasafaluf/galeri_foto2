<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Foto;
use App\Models\User;

class LikeFoto extends Model
{
    use HasFactory;

    protected $table = 'likefoto';
    protected $primaryKey = 'LikeID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'FotoID',
        'UserID',
        'TanggalLike',
    ];

    protected $casts = [
        'TanggalLike' => 'date',
    ];

    public function foto()
    {
        return $this->belongsTo(Foto::class, 'FotoID', 'FotoID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
