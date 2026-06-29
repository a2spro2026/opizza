<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reglements', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('fournisseur_id')->nullable()->constrained('fournisseurs')->nullOnDelete();
            $table->foreignId('bon_achat_id')->nullable()->constrained('bon_achats')->nullOnDelete();
            $table->decimal('montant_bon', 14, 2)->default(0);
            $table->string('ref_reglement')->nullable();
            $table->string('type_reglement')->nullable();
            $table->string('numero')->nullable();
            $table->string('banque')->nullable();
            $table->string('nom_tire')->nullable();
            $table->decimal('montant_reglement', 14, 2)->default(0);
            $table->date('date_decaissement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reglements');
    }
};
