<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_id',
        'file',
        'size',
        'type',
        'is_download',
        'is_tracking',
        
    ];

    public function File()
    {

        return $this->belongsTo(File::class);
    }

    public function reads()
{
    return $this->hasMany(UserRead::class);
}

}
