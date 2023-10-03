<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNbreJourPaimentToFactures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->integer('nbre_de_jour_de_paiement')->nullable();
            $table->string('statut_paiement')->nullable(); //deux valeurs possible: en retard, dans les delais

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn('nbre_de_jour_de_paiement');
            $table->dropColumn('statut_paiement');

        });
    }
}
