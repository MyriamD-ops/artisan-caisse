<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->string('url_image');
            $table->boolean('est_principale')->default(false);
            $table->integer('ordre_affichage')->default(0);
            $table->timestamps();
            
            $table->index('produit_id');
            $table->index(['produit_id', 'est_principale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images_produit');
    }
};
