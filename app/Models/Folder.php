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
        'user_group_id',
        'created_by',
        'cabang_id',
    ];

    public function UserGroup()
    {

        return $this->belongsTo(UserGroup::class, 'user_group_id');   
    
    }

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }
    
    public function DetailGroup()
    {

        return $this->hasMany(DetailGroup::class, 'folder_id');
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


    public function subfolders()
{
    return $this->hasMany(Folder::class, 'id_folder_induk');
}


public function parent_folder()
{
    return $this->belongsTo(Folder::class, 'id_folder_induk');
}

public function pinnedByUser()
{
    return $this->belongsTo(User::class, 'pinned_by_user_id');
}

public function getFullFolderPath()
{
    $path = [];

    $currentFolder = $this;

    while ($currentFolder) {
        $path[] = [
            'id' => $currentFolder->id,
            'nama_folder' => $currentFolder->nama_folder,
        ];

        $currentFolder = $currentFolder->parent_folder;
    }

    return array_reverse($path);
}


public function groups()
    {
        return $this->hasMany(UserGroup::class);
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
    
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

  

    
}

