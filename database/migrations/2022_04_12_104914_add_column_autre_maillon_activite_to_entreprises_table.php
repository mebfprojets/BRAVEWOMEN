<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAutreMaillonActiviteToEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            //$table->string("autre_maillon_activite")->nullable();
            $table->string("banque_entreprise")->nullable();
            //$table->string("autre_provenance_clientele")->nullable();
            //$table->string("autre_nature_clientele")->nullable();
            //$table->string("autre_systeme_de_suivi_activite")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn("banque_entreprise");
           // $table->dropColumn("autre_forme_juridique");
           // $table->dropColumn("autre_provenance_clientele");
            //$table->dropColumn("autre_nature_clientele");
            //$table->dropColumn("autre_systeme_de_suivi_activite");

        });
    }
}
