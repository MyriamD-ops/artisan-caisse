<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('variante_id')->nullable()->constrained('variantes')->onDelete('cascade');
            $table->enum('type_mouvement', ['entree', 'sortie', 'ajustement', 'retour', 'inventaire']);
            $table->integer('variation_quantite');
            $table->integer('stock_avant');
            $table->integer('stock_apres');
            $table->string('reference')->nullable();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('restrict');
            $table->timestamp('date_mouvement');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('produit_id');
            $table->index('variante_id');
            $table->index('type_mouvement');
            $table->index('date_mouvement');
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};
