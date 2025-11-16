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
        Schema::create('physical_tests', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
            $t->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Postur
            $t->decimal('height_cm', 5, 2)->nullable();
            $t->decimal('weight_kg', 5, 2)->nullable();
            $t->decimal('posture_score', 5, 2)->nullable(); // N.P (0–100)

            // Garjas A (lari 12 menit)
            $t->unsignedInteger('run_12min_meter')->nullable();
            $t->decimal('garjas_a_score', 5, 2)->nullable(); // N.A

            // Garjas B (1 menit masing2) + shuttle run
            //pria
            $t->unsignedSmallInteger('pull_up')->nullable();
            $t->unsignedSmallInteger('sit_up')->nullable();         // / modified
            $t->unsignedSmallInteger('push_up')->nullable();        // / modified
            $t->decimal('shuttle_run_sec', 5, 2)->nullable();
            //wanita
            $t->unsignedSmallInteger('chinning')->nullable();        // / chinning (wanita)
            $t->unsignedSmallInteger('modified_sit_up')->nullable();         // / modified
            $t->unsignedSmallInteger('modified_push_up')->nullable();        // / modified
            $t->decimal('garjas_b_avg_score', 5, 2)->nullable(); // N.RB

            // Nilai gabungan A & B
            $t->decimal('garjas_score', 5, 2)->nullable(); // N.G = (N.A + N.RB)/2

            // Renang
            $t->decimal('swim_50m_sec', 6, 2)->nullable();
            $t->decimal('swim_score', 5, 2)->nullable(); // N.R

            // Nilai Akhir Jasmani (NAJ)
            $t->decimal('naj', 5, 2)->nullable(); // NAJ = (NP*2 + NG*5 + NR*3)/10:contentReference[oaicite:6]{index=6}
            $t->timestamps();

            $t->unique(['mahasiswa_id', 'semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_tests');
    }
};
