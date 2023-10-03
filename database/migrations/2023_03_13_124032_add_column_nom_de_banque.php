<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNomDeBanque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->string('nom_de_banque')->nullable();
            $table->string('numero_de_compte')->nullable();
            $table->string('numero_de_telephone')->nullable();
            $table->string('detenteur_du_numero')->nullable();



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
            $table->dropColumn('nom_de_banque');
            $table->dropColumn('numero_de_compte');
            $table->dropColumn('numero_de_telephone');
            $table->dropColumn('detenteur_du_numero');

        });
    }
}
