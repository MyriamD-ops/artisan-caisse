<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_vente')->unique();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('restrict');
            $table->foreignId('evenement_id')->nullable()->constrained('evenements')->onDelete('set null');
            $table->decimal('montant_total', 10, 2);
            $table->enum('mode_paiement', ['especes', 'carte', 'mobile', 'autre'])->default('especes');
            $table->timestamp('date_vente');
            $table->boolean('synchronisee')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('numero_vente');
            $table->index('utilisateur_id');
            $table->index('evenement_id');
            $table->index('date_vente');
            $table->index('synchronisee');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
