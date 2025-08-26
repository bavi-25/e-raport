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
        Schema::create('grade_entries', function (Blueprint $table) {
            $table->id();
            $table->decimal('final_score', 6, 2);

            $table->foreignId('student_id')
                ->constrained('profiles', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('assessment_item_id')
                ->constrained('assessment_items', 'id')
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
        Schema::dropIfExists('grade_entries');
    }
};
