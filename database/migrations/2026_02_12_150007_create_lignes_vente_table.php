<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lignes_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('restrict');
            $table->foreignId('variante_id')->nullable()->constrained('variantes')->onDelete('restrict');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('sous_total', 10, 2);
            $table->decimal('remise', 10, 2)->default(0);
            $table->timestamps();
            
            $table->index('vente_id');
            $table->index('produit_id');
            $table->index('variante_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes_vente');
    }
};
