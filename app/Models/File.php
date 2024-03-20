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
        'status_persetujuan',
        'konten',
        'cabang_id_user',
        'catatan',
        'user_approval',
    ];

    public function folder()
{
    return $this->belongsTo(Folder::class, 'folder_id');
}

public function pinnedByUser()
{
    return $this->belongsTo(User::class, 'pinned_by_user_id');
}

public function pins()
{
    return $this->hasMany(Pin::class);
}

public function detailfiles()
{
    return $this->hasMany(DetailFile::class);
}

public function user()
{
    return $this->belongsTo(User::class, 'user_approval');
}

}
