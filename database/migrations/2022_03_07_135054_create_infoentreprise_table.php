<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoentrepriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoentreprises', function (Blueprint $table) {
            $table->id();
            $table->integer("annee");
            $table->integer("indicateur");
            $table->double("quantite");
            $table->string("code_promoteur");
            $table->string("entreprise_id");
            $table->integer("sexe")->nullable();
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
        Schema::dropIfExists('infoentreprises');
    }
}
