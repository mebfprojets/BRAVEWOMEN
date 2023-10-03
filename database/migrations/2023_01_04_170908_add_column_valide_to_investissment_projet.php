<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnValideToInvestissmentProjet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investissement_projets', function (Blueprint $table) {
            $table->integer('montant_valide')->nullable();
            $table->integer('apport_perso_valide')->nullable();
            $table->integer('subvention_demandee_valide')->nullable();
            $table->string('statut')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investissement_projets', function (Blueprint $table) {
            $table->dropColumn('montant_valide');
            $table->dropColumn('apport_perso_valide');
            $table->dropColumn('subvention_demandee_valide');
            $table->dropColumn('statut');

        });
    }
}
