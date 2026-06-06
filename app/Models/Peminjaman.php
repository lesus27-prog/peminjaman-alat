<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';
    protected $fillable = [
        'id_siswa',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'status_pinjam',
        'is_reminder_sent',
        'kelas_siswa'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function detailAlat()
    {
        return $this->belongsToMany(
            DetailAlat::class,
            'peminjaman_detail',
            'id_pinjam',
            'id_detail_alat'
        )->withPivot(
            'tanggal_pengembalian',
            'is_terlambat',
            'is_kembali',
            'kondisi_kembali',
            'catatan'
        )->withTimestamps();
    }

    public function tipeAlat()
    {
        return $this->belongsToMany(TipeAlat::class, 'peminjaman_tipe', 'id_pinjam', 'id_tipe')->withPivot('quantity')->withTimestamps();
    }

    public function cameraActive()
    {
        $waktuMulai = Carbon::parse($this->tanggal_mulai . ' ' . $this->jam_mulai);
        $waktuSelesai = Carbon::parse($this->tanggal_selesai . ' ' . $this->jam_selesai);
        $batasMulai = $waktuMulai->copy()->subMinutes(10);

        // $sekarang = Carbon::parse('2026-05-06 12:30');
        $sekarang = now();
        return $sekarang->greaterThanOrEqualTo($batasMulai) && $sekarang->lessThanOrEqualTo($waktuSelesai);
    }

    public function tanggalPemakaianFormat()
    {
        Carbon::setLocale('id');
        $waktu = Carbon::parse($this->tanggal_mulai . $this->jam_mulai);

        if ($waktu->isToday()) {
            return 'Hari ini, ' . $waktu->translatedFormat('d F Y H:i');
        } elseif ($waktu->isTomorrow()) {
            return 'Besok, ' . $waktu->translatedFormat('d F Y H:i');
        } else {
            return $waktu->translatedFormat('d F Y H:i');
        }
    }

    public function batasPengembalianFormat()
    {
        Carbon::setLocale('id');
        $waktu = Carbon::parse($this->tanggal_selesai . $this->jam_selesai);

        if ($waktu->isToday()) {
            return 'Hari ini, ' . $waktu->translatedFormat('d F Y H:i');
        } elseif ($waktu->isTomorrow()) {
            return 'Besok, ' . $waktu->translatedFormat('d F Y H:i');
        } else {
            return $waktu->translatedFormat('d F Y H:i');
        }
    }

    public function tanggalPeminjamanFormat()
    {
        Carbon::setLocale('id');
        $waktu = Carbon::parse($this->tanggal_mulai . $this->jam_mulai);
        return $waktu->translatedFormat('l, d F Y H:i');
    }

    public function batasKembaliFormat()
    {
        Carbon::setLocale('id');
        $waktu = Carbon::parse($this->tanggal_selesai . $this->jam_selesai);
        return $waktu->translatedFormat('l, d F Y H:i');
    }

    public function batasWaktu()
    {
        return Carbon::parse($this->tanggal_selesai . ' ' . $this->jam_selesai);
    }

    public function terlambat()
    {
        $now = Carbon::now();
        return $now->gt($this->batasWaktu());
    }

    public function keterlambatanText()
    {
        $now = Carbon::now();

        if (!$now->gt($this->batasWaktu())) {
            return null;
        }

        $diff = $this->batasWaktu()->diff($now);
        $text = [];

        if ($diff->d > 0) $text[] = $diff->d . ' hari';
        if ($diff->h > 0) $text[] = $diff->h . ' jam';
        if ($diff->i > 0) $text[] = $diff->i . ' menit';

        return implode(' ', $text);
    }
}
