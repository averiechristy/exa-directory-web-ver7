<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_group_id',
        
    ];

    public function User()
    {

        return $this->belongsTo(User::class);
    }

    public function UserGroup()
    {

        return $this->belongsTo(UserGroup::class);
    }

}
