<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();
            $table->string('denomination_entreprise');
            $table->string('nom_responsable');
            $table->string('prenom_responsable');
            $table->string('telephone');
            $table->integer('domaine_activite');
            $table->integer('region');
            $table->integer('province');
            $table->integer('commune');
            $table->string('code_prestaire');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('prestataires');
    }
}
