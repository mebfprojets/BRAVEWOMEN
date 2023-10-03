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
            $table->string('slug')->unique();
            $table->integer('coach_id')->nullable();
            $table->integer('zone_affectation')->nullable();
            $table->string('statut')->nullable();
            $table->text('motif_du_rejet_de_lanalyse')->nullable();
            $table->text('observations')->nullable();
            $table->integer("entreprise_id");
            $table->string("titre_du_projet");
            $table->text("objectifs");
            $table->text("activites_menees");
            $table->text("atouts_promoteur");
            $table->text("innovation");
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
