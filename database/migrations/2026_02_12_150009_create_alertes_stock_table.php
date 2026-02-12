<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertes_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->foreignId('variante_id')->nullable()->constrained('variantes')->onDelete('cascade');
            $table->integer('stock_actuel');
            $table->integer('seuil')->default(5);
            $table->enum('statut', ['active', 'resolue', 'ignoree'])->default('active');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index('produit_id');
            $table->index('variante_id');
            $table->index('statut');
            $table->index(['statut', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertes_stock');
    }
};
