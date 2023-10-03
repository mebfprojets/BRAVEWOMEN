<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoeffectifentreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoeffectifentreprises', function (Blueprint $table) {
            $table->id();
            $table->integer("annee");
            //effectif correspond au type de personnel
            $table->integer("effectif");
            $table->integer("homme");
            $table->integer("femme");
            $table->string("code_promoteur");
            $table->string("entreprise_id");
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
        Schema::dropIfExists('infoeffectifentreprises');
    }
}
