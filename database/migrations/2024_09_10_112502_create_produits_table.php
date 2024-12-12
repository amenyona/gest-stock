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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('forme_id');
            $table->unsignedBigInteger('famille_id');
            $table->string('nom');
            $table->string('description');
            $table->decimal('prix',12,5)->nullable();;
            $table->string('quantiteStock')->nullable();
            $table->string('dateExpiration')->nullable();;
            $table->string('quantiteSeuil')->nullable();;
            $table->string('image')->nullable();
            $table->boolean('worked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
