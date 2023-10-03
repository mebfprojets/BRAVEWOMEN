<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->String('slug')->unique();
            $table->integer('devi_id');
            $table->integer('entreprise_id');
            $table->integer('raison_rejet')->nullable();
            $table->text('observation')->nullable();
            $table->string('url_fac');
            $table->string('statut');
            $table->string('num_facture');
            $table->bigInteger('montant');
            $table->string('mode_de_paiement');
            $table->string('date_de_paiement'); 
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
        Schema::dropIfExists('factures');
    }
}
