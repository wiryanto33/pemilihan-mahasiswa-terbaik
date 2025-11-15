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
        Schema::create('academic_scors', function (Blueprint $t) {
            $t->id();
            $t->foreignId('mahasiswa_id')->constrained()->cascadeOnDelete();
            $t->foreignId('matakuliah_id')->constrained()->cascadeOnDelete();
            $t->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Nilai komponen (0–100)
            $t->decimal('nu', 5, 2)->nullable();  // ulangan/kuis/responsi
            $t->decimal('uts', 5, 2)->nullable();
            $t->decimal('uas', 5, 2)->nullable();

            // Nilai akhir & huruf (opsional cache)
            $t->decimal('final_numeric', 5, 2)->nullable(); // N = (2NU+3UTS+5UAS)/10:contentReference[oaicite:4]{index=4}
            $t->string('final_letter', 3)->nullable();      // A, B+, B, C+, C, D, E

            $t->timestamps();
            $t->unique(['mahasiswa_id', 'matakuliah_id', 'semester_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_scors');
    }
};
