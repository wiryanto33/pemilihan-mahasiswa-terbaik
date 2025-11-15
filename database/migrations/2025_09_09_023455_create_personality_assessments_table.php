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
        Schema::create('personality_assessments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
            $t->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Skala 0–100 (atau 0–4 lalu konversi), mengikuti format NPK sublampiran I/II
            $t->decimal('director_score', 5, 2)->nullable(); // bobot 20%
            $t->decimal('korsis_score', 5, 2)->nullable();   // bobot 50%
            $t->decimal('kaprodi_score', 5, 2)->nullable();  // bobot 30%
            $t->decimal('npk_final', 5, 2)->nullable();      // agregat bobot:contentReference[oaicite:5]{index=5}

            $t->timestamps();
            $t->unique(['mahasiswa_id', 'semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personality_assessments');
    }
};
