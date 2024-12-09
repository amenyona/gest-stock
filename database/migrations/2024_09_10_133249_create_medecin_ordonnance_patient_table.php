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
        Schema::create('medecin_ordonnance_patient', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('medecin_id')->constrained();
            $table->foreignId('ordonnance_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->string('datePrescription');
            $table->string('dateEnregistrement');
            $table->boolean('worked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medecin_ordonnance_patient');
    }
};
