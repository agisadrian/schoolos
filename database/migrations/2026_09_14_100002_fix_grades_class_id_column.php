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
     * Kode aplikasi (app/Models/Grade.php,
     * app/Models/SchoolClass.php, dan GradeController)
     * menggunakan kolom `class_id`, tapi pada sebagian
     * instalasi database kolom ini tidak ada / masih
     * bernama lain. Migration ini memeriksa kondisi
     * kolom yang sebenarnya sebelum mengubah apa pun,
     * supaya aman dijalankan berkali-kali dan tidak
     * menghapus data yang sudah ada.
     */
    public function up(): void
    {
        if (!Schema::hasTable('grades')) {
            return;
        }

        if (Schema::hasColumn('grades', 'class_id')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        $alternatives = [
            'school_class_id',
            'schoolclass_id',
            'classroom_id',
        ];

        foreach ($alternatives as $old) {
            if (Schema::hasColumn('grades', $old)) {
                $this->renameColumn('grades', $old, 'class_id', $driver);

                return;
            }
        }

        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('class_id')
                ->after('id')
                ->constrained('school_classes')
                ->cascadeOnDelete();
        });
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
        DB::statement(
            "ALTER TABLE `{$table}` CHANGE `{$from}` `{$to}` BIGINT UNSIGNED NOT NULL"
        );
    }
};
