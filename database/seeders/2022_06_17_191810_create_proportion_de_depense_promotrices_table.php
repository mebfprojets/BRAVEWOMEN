<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProportionDeDepensePromotricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proportion_de_depense_promotrices', function (Blueprint $table) {
            $table->id();
            $table->integer("annee_id");
            $table->integer("promotrice_id");
            $table->integer("proportion_id");
            $table->integer("pourcentage");
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
        Schema::dropIfExists('proportion_de_depense_promotrices');
    }
}
