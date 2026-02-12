<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->string('taille')->nullable();
            $table->string('couleur')->nullable();
            $table->string('matiere')->nullable();
            $table->integer('stock_quantite')->default(0);
            $table->decimal('ajustement_prix', 10, 2)->default(0);
            $table->string('sku')->unique()->nullable();
            $table->timestamps();
            
            $table->index('produit_id');
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes');
    }
};
