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
        Schema::create('program_studies', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique(); // mis: TIS, TIB, TMB
            $t->string('name');
            $t->enum('level', ['D3', 'S1', 'S2']); // penting utk syarat kelulusan/predikat:contentReference[oaicite:2]{index=2}
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studies');
    }
};
