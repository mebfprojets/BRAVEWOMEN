<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("denomination");
            $table->integer("region");
            $table->integer("province");
            $table->integer("commune");
            $table->integer("arrondissement");
            $table->string("telephone_entreprise");
            $table->string("email_entreprise");
            $table->string("secteur_activite");
            $table->integer("nombre_annee_existence");
            $table->integer("maillon_activite");
            $table->integer("formalise");
            $table->integer("num_rccm")->nullable();
            $table->date("date_de_formalisation")->nullable();
            $table->integer("forme_juridique")->nullable();
            $table->integer("agrement_exige");
            $table->integer("agrement_dispo");
            $table->integer("compte_dispo");
            $table->text("description_activite");
            $table->integer("source_appro");
            $table->integer("nature_client");
            $table->integer("systeme_suivi")->nullable();
            $table->integer("type_sys_suivi")->nullable();
            $table->string("code_promoteur");
            $table->integer("provenance_clientele");
            $table->integer("promotrice_id");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
}
