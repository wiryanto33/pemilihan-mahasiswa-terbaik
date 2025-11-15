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
        Schema::table('users', function (Blueprint $table) {
            // sesuaikan posisi kolom (after...) kalau mau
            $table->foreignId('program_study_id')
                ->nullable() // buat nullable dulu agar aman untuk data existing
                ->constrained('program_studies') // nama tabel referensi
                ->nullOnDelete(); // jika prodi dihapus, set kolom ini ke null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_study_id');
            // setara dengan dropForeign+dropColumn untuk kolom fk ini
        });
    }
};
