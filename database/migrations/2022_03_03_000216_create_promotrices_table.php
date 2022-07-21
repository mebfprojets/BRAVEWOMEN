<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotrices', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("prenom");
            $table->date("datenais");
            $table->integer("genre");
            $table->string("telephone_promoteur");
            $table->string("mobile_promoteur")->nullable();
            $table->string("email_promoteur")->nullable();
            $table->integer("region_residence");
            $table->integer("province_residence");
            $table->integer("commune_residence");
            $table->integer("arrondissement_residence");
            $table->string("precision_residence")->nullable();
            $table->integer("situation_residence");
            $table->integer("type_identite");
            $table->string("numero_identite");
            $table->date("date_etabli_identite");
            // $table->date("date_expire_identite");
            // $table->integer("autorite_delivrance");
            // $table->string("lieu_etablissement");
            $table->integer("niveau_instruction");
            $table->string("autre_niveau_dinstruction")->nullable();
            $table->integer("formation_en_rapport_avec_activite");
            $table->integer("occupation_professionnelle_actuelle")->nullable();
            $table->string("autre_occupation_pro")->nullable();
            $table->integer("nombre_annee_experience");
            $table->string("autre_experience")->nullable();
            $table->string("code_promoteur");
            $table->integer("membre_ass");
            $table->integer("status")->nullable();
            $table->string("associations")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotrices');
    }
}
