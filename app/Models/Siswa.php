<?php

namespace App\Models;

use App\Models\AkunUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $fillable = [
        'id_akun_user',
        'nama_siswa',
        'nis',
        'kelas',
        'jenis_kelamin',
        'tahun_masuk'
    ];

    public function akunUser()
    {
        return $this->belongsTo(AkunUser::class, 'id_akun_user', 'id_akun_user');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_siswa', 'id_siswa');
    }
}
