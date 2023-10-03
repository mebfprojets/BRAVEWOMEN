<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComptePersoExisteColumnToPromotriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Promotrices', function (Blueprint $table) {
           $table->string("compte_perso_existe")->nullable();
           $table->string("structure_financiere_personne")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Promotrices', function (Blueprint $table) {
            $table->dropColumn("compte_perso_existe");
            $table->dropColumn("structure_financiere_personne");
        });
    }
}
