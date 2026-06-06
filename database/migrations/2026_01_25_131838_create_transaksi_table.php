
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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjam');
            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status_pinjam', [
                'menunggu',
                'siap diambil',
                'aktif',
                'proses pengembalian',
                'batal',
                'selesai'
            ])->default('menunggu');
            $table->boolean('is_reminder_sent')->default(false);
            $table->string('kelas_siswa');
            $table->timestamps();
        });

        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->foreignId('id_pinjam')
                ->constrained('peminjaman', 'id_pinjam')
                ->cascadeOnDelete();

            $table->foreignId('id_detail_alat')
                ->constrained('detail_alat', 'id_detail_alat')
                ->cascadeOnDelete();

            $table->dateTime('tanggal_pengembalian')->nullable();
            $table->boolean('is_kembali')->default(false);
            $table->enum('kondisi_kembali', [
                'baik',
                'perlu perbaikan',
                'rusak',
                'hilang'
            ])->default('baik')->nullable();
            $table->string('catatan')->nullable();
            $table->boolean('is_terlambat')->default(false);
            $table->timestamps();
        });

        Schema::create('peminjaman_tipe', function (Blueprint $table) {
            $table->foreignId('id_pinjam')
                ->constrained('peminjaman', 'id_pinjam')
                ->cascadeOnDelete();

            $table->foreignId('id_tipe')
                ->constrained('tipe_alat', 'id_tipe')
                ->cascadeOnDelete();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_tipe');
        Schema::dropIfExists('peminjaman_detail');
        Schema::dropIfExists('peminjaman');
    }
};
