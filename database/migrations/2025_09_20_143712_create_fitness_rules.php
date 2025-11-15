<?php

// database/migrations/2025_09_20_000001_create_fitness_rules.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fitness_rule_sets', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->date('effective_date')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('fitness_age_brackets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rule_set_id')->constrained('fitness_rule_sets')->cascadeOnDelete();
            $t->enum('gender', ['male', 'female']);
            $t->unsignedTinyInteger('age_min');
            $t->unsignedTinyInteger('age_max');
            $t->timestamps();
            $t->unique(['rule_set_id', 'gender', 'age_min', 'age_max'], 'uniq_bracket');
        });

        Schema::create('fitness_metrics', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rule_set_id')->constrained('fitness_rule_sets')->cascadeOnDelete();
            $t->string('key');              // e.g. run_12min, pull_up, shuttle_run, swim_50m, posture_bmi_delta, posture_category
            $t->enum('direction', ['min', 'max'])->nullable(); // null utk kategori
            $t->string('unit')->nullable(); // meter, rep, sec, bmi
            $t->timestamps();
            $t->unique(['rule_set_id', 'key']);
        });

        Schema::create('fitness_thresholds', function (Blueprint $t) {
            $t->id();
            $t->foreignId('age_bracket_id')->constrained('fitness_age_brackets')->cascadeOnDelete();
            $t->foreignId('metric_id')->constrained('fitness_metrics')->cascadeOnDelete();
            $t->decimal('min_value', 8, 2)->nullable();
            $t->decimal('max_value', 8, 2)->nullable();
            $t->unsignedTinyInteger('score'); // 0-100
            $t->timestamps();
            $t->index(['metric_id', 'age_bracket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_thresholds');
        Schema::dropIfExists('fitness_metrics');
        Schema::dropIfExists('fitness_age_brackets');
        Schema::dropIfExists('fitness_rule_sets');
    }
};
