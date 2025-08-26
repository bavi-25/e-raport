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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->foreignId('enrollment_id')
                ->constrained('enrollments', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('class_subject_id')
                ->constrained('class_subjects', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('assessment_component_id')
                ->constrained('assessment_components', 'id')
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
        Schema::dropIfExists('assessments');
    }
};
