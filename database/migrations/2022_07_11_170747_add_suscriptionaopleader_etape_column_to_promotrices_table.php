<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuscriptionaopleaderEtapeColumnToPromotricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotrices', function (Blueprint $table) {
           $table->integer("suscriptionaopleader_etape")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotrices', function (Blueprint $table) {
            $table->dropColumn("suscriptionaopleader_etape");
        });
    }
}
