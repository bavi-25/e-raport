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
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->decimal('final_score', 6, 2);

            $table->foreignId('class_subject_id')
                ->constrained('class_subjects', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            
            $table->foreignId('student_id')
                ->constrained('profiles', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('tenant_id')
                ->constrained('tenants', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['class_subject_id', 'student_id', 'tenant_id'], 'uq_final_grades_tenant_student_subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('final_grades');
        Schema::table('final_grades', function (Blueprint $table) {
            $table->dropUnique('uq_final_grades_tenant_student_subject');
        });
    }
};
