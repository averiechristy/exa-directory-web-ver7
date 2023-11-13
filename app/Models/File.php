<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'nama_file',
        'type',
        'size',
        'is_download',
        'status',
        'created_by',
        'updated_by',
        'file',
    ];

    public function folder()
{
    return $this->belongsTo(Folder::class, 'folder_id');
}
}
