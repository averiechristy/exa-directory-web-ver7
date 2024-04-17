<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_cabang',
        'nama_cabang',
        'updated_by',
        'created_by',
    ];

    public function User()
    {

        return $this->hasMany(User::class);
    }

    public function detailmember()
    {

        return $this->hasMany(DetailMember::class);
    }


    public function UserGroup()
    {

        return $this->hasMany(UserGroup::class);
    }

}
