<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'cabang_id',
        'nama_group',
        'created_by',
        'updated_by',
    ];

    public function Cabang()
    {

        return $this->belongsTo(Cabang::class);
    }

    public function DetailMember()
    {

        return $this->hasMany(DetailMember::class);
    }

    public function Folder()
    {

        return $this->hasMany(Folder::class);
    }

    public function DetailGroup()
    {

        return $this->hasMany(DetailGroup::class);
    }
}
