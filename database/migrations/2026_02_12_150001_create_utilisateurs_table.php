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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('pin_hash');
            $table->string('fingerprint_id')->nullable();
            $table->enum('role', ['admin', 'vendeur'])->default('vendeur');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
