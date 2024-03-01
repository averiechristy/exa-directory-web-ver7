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
        
    ];

    public function File()
    {

        return $this->belongsTo(File::class);
    }
}
