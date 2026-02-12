<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs_synchronisation', function (Blueprint $table) {
            $table->id();
            $table->enum('type_sync', ['produits', 'ventes', 'stocks', 'complete']);
            $table->enum('statut', ['succes', 'echec', 'partiel']);
            $table->integer('nombre_enregistrements')->default(0);
            $table->text('message_erreur')->nullable();
            $table->timestamp('date_sync');
            
            $table->index('type_sync');
            $table->index('statut');
            $table->index('date_sync');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_synchronisation');
    }
};
