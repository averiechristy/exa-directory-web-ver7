<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_folder_induk',
       'nama_folder',
        'updated_by',
        'created_by',
    ];

    public function UserGroup()
    {

        return $this->belongsTo(UserGroup::class);
    }

    public function DetailGroup()
    {

        return $this->hasMany(DetailGroup::class);
    }

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'id_folder_induk');
    }

    public function childFolders()
    {
        return $this->hasMany(Folder::class, 'id_folder_induk');
    }


    public function getFolderPath()
    {
        $path = $this->nama_folder;

        // Jika ada folder induk, gabungkan dengan path folder induk
        if ($this->id_folder_induk) {
            $parentFolder = Folder::find($this->id_folder_induk);
            $path = $parentFolder->getFolderPath() . '/' . $path;
        }

        return $path;
    }

}
