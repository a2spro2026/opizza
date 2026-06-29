<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bon_achats', function (Blueprint $table) {
            $table->date('date')->nullable()->after('id');
            $table->string('ref_bn')->nullable()->after('date');
            $table->foreignId('fournisseur_id')->nullable()->after('ref_bn')->constrained('fournisseurs')->nullOnDelete();
            $table->string('ref_article')->nullable()->after('fournisseur_id');
            $table->string('designation')->nullable()->after('ref_article');
            $table->decimal('qte', 12, 2)->default(0)->after('designation');
            $table->decimal('prix_u', 12, 2)->default(0)->after('qte');
            $table->decimal('sous_total', 14, 2)->default(0)->after('prix_u');
            $table->string('type_reglement')->nullable()->after('sous_total');
            $table->decimal('montant_reglement', 14, 2)->default(0)->after('type_reglement');
            $table->unsignedInteger('echeance')->nullable()->after('montant_reglement');
        });
    }

    public function down(): void
    {
        Schema::table('bon_achats', function (Blueprint $table) {
            $table->dropConstrainedForeignId('fournisseur_id');
            $table->dropColumn([
                'date', 'ref_bn', 'ref_article', 'designation',
                'qte', 'prix_u', 'sous_total', 'type_reglement',
                'montant_reglement', 'echeance',
            ]);
        });
    }
};
