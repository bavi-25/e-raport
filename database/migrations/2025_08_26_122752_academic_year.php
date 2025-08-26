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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('term', ['Ganjil', 'Genap']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('academic_years');
    }
};
