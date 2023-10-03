<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCovidColumnToEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->integer("affecte_par_covid")->nullable();
            $table->text("description_effect_covid")->nullable();
            $table->integer("affecte_par_securite")->nullable();
            $table->integer("niveau_resilience")->nullable();
            $table->string("mobililise_contrepartie")->nullable();

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
           $table->dropColumn("affecte_par_covid");
           $table->dropColumn("description_effect_covid");
           $table->dropColumn("affecte_par_securite");
           $table->dropColumn("niveau_resilience");
           $table->dropColumn("mobililise_contrepartie");
        });
    }
}
