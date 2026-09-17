<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom `status` pada tabel `class_members`
     * untuk mendukung alur persetujuan gabung kelas.
     *
     * - 'approved' : anggota aktif, bisa akses konten kelas
     *   (default, supaya anggota lama yang sudah ada tetap
     *   bisa akses seperti biasa tanpa perlu approval ulang).
     * - 'pending'  : baru mengajukan gabung lewat kode kelas,
     *   menunggu disetujui admin/guru.
     */
    public function up(): void
    {
        if (Schema::hasColumn('class_members', 'status')) {
            return;
        }

        Schema::table('class_members', function (Blueprint $table) {
            $table->string('status')
                ->default('approved')
                ->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('class_members', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
