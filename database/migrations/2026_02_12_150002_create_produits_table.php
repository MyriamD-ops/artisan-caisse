<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('categorie')->nullable();
            $table->decimal('prix_base', 10, 2);
            $table->string('code_barres')->unique()->nullable();
            $table->string('qr_code')->unique()->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->index('categorie');
            $table->index('actif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
