<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cabang_id',
        'role_id',
        'nama_user',
        'email',
        'password',
        'no_pegawai',
        'updated_by',
        'created_by',
        'is_approved',
        'is_approval',
        'report_to',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function Role()
    {

        return $this->belongsTo(UserRole::class);
    }

    public function File()
    {

        return $this->belongsTo(File::class);
    }

    public function Cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function DetailMember()
    {
        return $this->hasMany(DetailMember::class);
    }

    
    public function pins()
    {
        return $this->hasMany(Pin::class);
    }

    public function reads()
    {
        return $this->hasMany(UserRead::class);
    }

    public function isAdmin()
{
    $jenis_role = $this->Role->nama_role;
    return strtoupper($jenis_role) === 'ADMIN';
}

public function isSuperAdmin()
{
    $jenis_role = $this->Role->nama_role;
    return strtoupper($jenis_role) === 'SUPER ADMIN';
}



public function isApproval()
{
    $jenis_role = $this->Role->nama_role;
    return strtoupper($jenis_role) === 'APPROVAL';
}

public function isFolderPinned($folderId)
{
    return $this->pins()->where('folder_id', $folderId)->exists();
}

public function isFilePinned($fileId)
{
    return $this->pins()->where('file_id', $fileId)->exists();
}
public function isFileRead($detailfileId)
{
    return $this->reads()->where('detail_file_id', $detailfileId)->exists();
}
}

