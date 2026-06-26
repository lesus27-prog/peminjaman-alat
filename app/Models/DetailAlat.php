<?php

namespace App\Models;

use App\Models\TipeAlat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAlat extends Model
{
    use HasFactory;
    protected $table = 'detail_alat';
    protected $primaryKey = 'id_detail_alat';
    protected $fillable = [
        'id_tipe',
        'kode_alat',
        'kondisi_alat',
        'qr_code',
        'status_alat',
    ];

    public function tipeAlat()
    {
        return $this->belongsTo(TipeAlat::class, 'id_tipe', 'id_tipe');
    }

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_detail', 'id_detail_alat', 'id_pinjam')->withPivot(
            'tanggal_pengembalian',
            'is_terlambat',
            'is_scan_kembali',
            'kondisi_kembali',
            'catatan'
        )->withTimestamps();
    }

    protected static function booted()
    {
        $updateStok = function ($detail) {
            $detail->tipeAlat->update([
                'stok' => $detail->tipeAlat->detailAlat()
                    ->where('kondisi_alat', 'baik')
                    ->count()
            ]);
        };

        static::created($updateStok);
        static::deleted($updateStok);
        static::updated(function ($detail) use ($updateStok) {
            if ($detail->wasChanged('kondisi_alat')) {
                $updateStok($detail);
            }
        });
    }
}
