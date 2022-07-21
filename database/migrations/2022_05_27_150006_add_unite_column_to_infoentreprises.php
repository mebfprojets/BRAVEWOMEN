<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniteColumnToInfoentreprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infoentreprises', function (Blueprint $table) {
            $table->string("unite_de_mesure")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('infoentreprises', function (Blueprint $table) {
            $table->dropColumn("unite_de_mesure");
        });
    }
}
