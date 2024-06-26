<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserModel extends Authenticatable implements JWTSubject{
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return[];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'image'];
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id');
    }
    public function stok(): HasMany{
        return $this->hasMany(StokModel::class, 'user_id', 'user_id');
    }
    public function transaksi(): HasMany{
        return $this->hasMany(TransaksiModel::class, 'user_id', 'user_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts' . $image),
        );
    }
}