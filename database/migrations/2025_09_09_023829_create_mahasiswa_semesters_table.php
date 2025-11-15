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
        Schema::create('mahasiswa_semesters', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
            $t->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Akademik
            $t->decimal('ips', 4, 2)->nullable();
            $t->decimal('ipk', 4, 2)->nullable();

            // Normalisasi NPA (0–100) untuk formula NA.
            // Umumnya NPA dapat diambil dari skala IP (0–4) -> *25 agar setara 0–100.
            $t->decimal('npa', 5, 2)->nullable();

            // Kepribadian & Jasmani (0–100)
            $t->decimal('npk', 5, 2)->nullable();
            $t->decimal('npj', 5, 2)->nullable(); // bisa = NAJ

            // Nilai akhir peringkat
            $t->decimal('na', 5, 2)->nullable(); // NA = (7*NPA + 2*NPK + 1*NPJ)/10:contentReference[oaicite:7]{index=7}

            // Status persyaratan naik semester
            $t->boolean('eligible_next')->default(false);

            $t->timestamps();
            $t->unique(['mahasiswa_id', 'semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_semesters');
    }
};
