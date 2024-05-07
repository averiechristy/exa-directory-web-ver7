<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRead extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'detail_file_id',
        'user_id',
        'nama_file',
        'nama_user',
     ];
 

     public function detailfile()
    {
        return $this->belongsTo(DetailFile::class, 'detail_file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
