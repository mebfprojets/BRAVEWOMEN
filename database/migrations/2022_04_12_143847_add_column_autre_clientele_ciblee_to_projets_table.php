<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAutreClienteleCibleeToProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
           $table->string("autre_clientele_ciblee")->nullable();
           $table->string("autre_techno_actuelle")->nullable();
           $table->string("autre_techno_utilisee_dans_le_projet")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn("autre_clientele_ciblee")->nullable();
            $table->dropColumn("autre_techno_actuelle")->nullable();
            $table->dropColumn("autre_techno_utilisee_dans_le_projet")->nullable();
        });
    }
}
