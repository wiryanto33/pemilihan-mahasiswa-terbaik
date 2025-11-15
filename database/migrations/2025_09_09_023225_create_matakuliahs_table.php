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
        Schema::create('matakuliahs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('program_study_id')->constrained()->cascadeOnDelete();
            $t->string('code', 30)->unique();
            $t->string('name');
            $t->unsignedTinyInteger('sks'); // bobot SKS:contentReference[oaicite:3]{index=3}
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};
