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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 45)->unique();
            $table->string('nome', 45);
            $table->date('data_nascimento')->nullable();
            $table->text('biografia')->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('nacionalidade', 45)->nullable();
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
