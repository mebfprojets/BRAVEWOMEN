<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->text("objectif");
            $table->integer("innovation");
            $table->text("desc_innovation");
            $table->text("produit_propose");
            $table->string("technologie_actuel");
            $table->string("technologie_projet");
            $table->integer("source_apros");
            $table->integer("nature_clientele");
            $table->double("cout_investissement");
            $table->double("fond_roulement");
            $table->double("cout_total");
            $table->double("apport_perso");
            $table->string("entreprise_id");
            $table->double("subvention_demandee");
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
        Schema::dropIfExists('projets');
    }
}
