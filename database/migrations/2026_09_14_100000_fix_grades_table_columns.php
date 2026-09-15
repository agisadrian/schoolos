<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Memperbaiki drift skema pada tabel `grades`.
     *
     * Kode aplikasi (app/Models/Grade.php dan
     * DashboardController) menggunakan kolom
     * `student_id` dan `entered_by`, tapi pada sebagian
     * instalasi database kolom ini masih bernama
     * `user_id` / `created_by` (nama lama sebelum
     * migration aslinya diedit). Migration ini
     * memeriksa kondisi kolom yang sebenarnya sebelum
     * mengubah apa pun, supaya aman dijalankan berkali-kali
     * dan tidak menghapus data yang sudah ada.
     */
    public function up(): void
    {
        if (!Schema::hasTable('grades')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        // student_id
        if (
            !Schema::hasColumn('grades', 'student_id') &&
            Schema::hasColumn('grades', 'user_id')
        ) {
            $this->renameColumn('grades', 'user_id', 'student_id', $driver);
        } elseif (
            !Schema::hasColumn('grades', 'student_id') &&
            !Schema::hasColumn('grades', 'user_id')
        ) {
            Schema::table('grades', function (Blueprint $table) {
                $table->foreignId('student_id')
                    ->after('subject_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            });
        }

        // entered_by
        if (
            !Schema::hasColumn('grades', 'entered_by') &&
            Schema::hasColumn('grades', 'created_by')
        ) {
            $this->renameColumn('grades', 'created_by', 'entered_by', $driver);
        } elseif (
            !Schema::hasColumn('grades', 'entered_by') &&
            !Schema::hasColumn('grades', 'created_by')
        ) {
            Schema::table('grades', function (Blueprint $table) {
                $table->foreignId('entered_by')
                    ->after('student_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Sengaja dikosongkan — ini migration perbaikan
        // data/skema, bukan fitur baru yang perlu di-rollback.
    }

    private function renameColumn(
        string $table,
        string $from,
        string $to,
        string $driver
    ): void {
        if ($driver === 'sqlite') {
            Schema::table($table, function (Blueprint $blueprint) use ($from, $to) {
                $blueprint->renameColumn($from, $to);
            });

            return;
        }

        // MySQL/MariaDB: pakai raw SQL supaya tidak
        // butuh paket doctrine/dbal.
        $columnType = 'BIGINT UNSIGNED NOT NULL';

        DB::statement(
            "ALTER TABLE `{$table}` CHANGE `{$from}` `{$to}` {$columnType}"
        );
    }
};
