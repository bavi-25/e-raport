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
        //
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section')->nullable();
            $table->string('label')->nullable();
            $table->foreignId('academic_year_id')
                ->constrained('academic_years', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('grade_level_id')
                ->constrained('grade_levels', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('tenant_id')
                ->constrained('tenants', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('homeroom_teacher_id')
                ->constrained('profiles', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('classes');
    }
};
