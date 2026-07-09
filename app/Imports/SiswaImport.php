<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\AkunUser;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        if (
            !isset($row['nis']) ||
            !isset($row['nama']) ||
            !isset($row['kelas']) ||
            !isset($row['jenis_kelamin']) ||
            !isset($row['tahun_masuk'])
        ) {
            throw new \Exception;
        }

        if (
            empty($row['nis']) ||
            empty($row['nama']) ||
            empty($row['kelas']) ||
            empty($row['jenis_kelamin']) ||
            empty($row['tahun_masuk'])
        ) {
            return null;
        }

        $siswaExist = Siswa::where('nis', $row['nis'])->exists();

        if ($siswaExist) {
            return null;
        }


        // ==============================
        // JIKA BELUM ADA → BUAT BARU
        // ==============================


        $password = str_replace(['/', '.'], '', $row['nis']);
        $akun = AkunUser::create([
            'username' => (string) $row['nis'],
            'password' => Hash::make($password),
            'role' => 'siswa',
        ]);

        return new Siswa([
            'id_akun_user' => $akun->id_akun_user,
            'nama_siswa' => strtolower($row['nama']),
            'nis' => $row['nis'],
            'kelas' => strtolower($row['kelas']),
            'jenis_kelamin' => strtolower($row['jenis_kelamin']),
            'tahun_masuk' => strtolower($row['tahun_masuk']),
        ]);




        return null;
    }
}
