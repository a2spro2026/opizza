<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->date('date_creation');
            $table->string('code')->unique();
            $table->string('nom');
            $table->string('ville')->nullable();
            $table->string('contact')->nullable();
            $table->string('type_reglement')->nullable();
            $table->integer('echeance')->default(0);
            $table->decimal('solde_initial', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
