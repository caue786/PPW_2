<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagem_filme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filme_id')->constrained('filmes')->onDelete('cascade');
            $table->foreignId('imagem_id')->constrained('imagens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagem_filme');
    }
};
