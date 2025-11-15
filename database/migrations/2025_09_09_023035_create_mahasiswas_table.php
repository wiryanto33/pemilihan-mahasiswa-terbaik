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
        Schema::create('mahasiswas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('program_study_id')->constrained()->cascadeOnDelete();
            $t->string('nrp')->unique();
            $t->string('foto')->nullable();
            $t->string('name');
            $t->string('pangkat')->nullable();
            $t->string('korps')->nullable();
            $t->string('angkatan')->nullable(); // tahun/gelombang
            $t->enum('gender', ['Pria', 'Wanita'])->nullable();
            $t->date('birth_date')->nullable();
            $t->boolean('active')->default(true);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
