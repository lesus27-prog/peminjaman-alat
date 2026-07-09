<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('akun_user', function (Blueprint $table) {
            $table->id('id_akun_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('fcm_token')->nullable();
            $table->enum('role', [
                'siswa',
                'admin',
                'kabeng'
            ]);
            $table->enum('status_akun', [
                'aktif',
                'nonaktif'
            ])->default('aktif');
            $table->timestamps();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('id_akun_user')
                ->constrained('akun_user', 'id_akun_user')
                ->cascadeOnDelete();
            $table->string('nama_siswa');
            $table->string('nis', 13)->unique();
            $table->string('kelas', 10);
            $table->enum('jenis_kelamin', [
                'perempuan',
                'laki-laki'
            ]);
             $table->string('tahun_masuk', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('akun_user');
    }
};
