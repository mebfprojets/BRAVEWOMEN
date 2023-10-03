<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestissementProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investissement_projets', function (Blueprint $table) {
            $table->id();
            $table->integer('designation');
            $table->integer('montant');
            $table->integer('apport_perso');
            $table->integer('subvention_demandee');
         $table->unsignedBigInteger('projet_id');

            $table->timestamps();
           // $table->foreignId('projet_id')->references('id')->on('projets');
           // Schema::enableForeignKeyConstraints();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investissement_projets');
    }
}
