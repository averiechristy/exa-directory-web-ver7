<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'user_group_id',
        'cabang_id',
        
    ];

    public function Folder()
    {

        return $this->belongsTo(Folder::class);
    }

    public function UserGroup()
    {

        return $this->belongsTo(UserGroup::class);
    }

    public function detailMembers()
    {
        return $this->hasMany(DetailMember::class, 'user_group_id');
    }

    
}
