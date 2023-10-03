<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetinfos', function (Blueprint $table) {
            $table->id();
            $table->integer("annee");
            $table->integer("critere");
            $table->integer("valeur");
            $table->string("projet_id");
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
        Schema::dropIfExists('projetinfos');
    }
}
