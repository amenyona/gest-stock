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
        Schema::create('fournisseur_produit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('fournisseur_id')->constrained();
            $table->foreignId('produit_id')->constrained();
            $table->integer('reglement_id')->nullable();
            $table->uuid('uuid');
            $table->integer('livraison_id')->nullable();
            $table->string('dateCommande')->nullable();
            $table->string('dateExpereLivraison')->nullable();
            $table->integer('quantiteCommande')->nullable();
            $table->integer('quantiteLivraison')->nullable();
            $table->integer('quantitedefectuese')->nullable();
            $table->string('dateLivraison')->nullable();
            $table->decimal('prixLivraison',8,2)->nullable();
            $table->string('commandé')->nullable();
            $table->string('livré')->nullable();
            $table->string('résolu')->nullable();
            $table->string('numeroCommande')->nullable();
            $table->boolean('worked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseur_produit');
    }
};
