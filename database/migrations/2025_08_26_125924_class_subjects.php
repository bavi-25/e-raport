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
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')
                ->constrained('classes', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('subject_id')
                ->constrained('subjects', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('teacher_id')
                ->constrained('profiles', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('tenant_id')
                ->constrained('tenants', 'id')
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
        Schema::dropIfExists('class_subjects');
    }
};
