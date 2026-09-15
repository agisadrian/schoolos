<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Memperbaiki drift skema pada tabel `schedules`.
     *
     * Kode aplikasi (app/Models/Schedule.php dan
     * DashboardController) menggunakan kolom `day`,
     * tapi pada sebagian instalasi database kolom ini
     * masih bernama `day_of_week` (nama lama sebelum
     * migration aslinya diedit). Migration ini memeriksa
     * kondisi kolom yang sebenarnya sebelum mengubah apa
     * pun, supaya aman dijalankan berkali-kali dan tidak
     * menghapus data yang sudah ada.
     */
    public function up(): void
    {
        if (!Schema::hasTable('schedules')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        if (
            !Schema::hasColumn('schedules', 'day') &&
            Schema::hasColumn('schedules', 'day_of_week')
        ) {
            $this->renameColumn('schedules', 'day_of_week', 'day', $driver);
        } elseif (
            !Schema::hasColumn('schedules', 'day') &&
            !Schema::hasColumn('schedules', 'day_of_week')
        ) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->string('day')->after('teacher_id');
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
        DB::statement(
            "ALTER TABLE `{$table}` CHANGE `{$from}` `{$to}` VARCHAR(255) NOT NULL"
        );
    }
};
