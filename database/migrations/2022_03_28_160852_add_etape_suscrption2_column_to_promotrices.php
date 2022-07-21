<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtapeSuscrption2ColumnToPromotrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotrices', function (Blueprint $table) {
            $table->integer("etape_suscription2")->nullable();
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
            $table->dropColumn("etape_suscription2");
        });
    }
}
