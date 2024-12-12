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
        Schema::create('client_produit', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('commandeClient_id')->constrained();
            $table->foreignId('client_id')->constrained();
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
        Schema::dropIfExists('client_produit');
    }
};
