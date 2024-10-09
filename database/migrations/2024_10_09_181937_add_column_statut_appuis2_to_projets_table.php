<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatutAppuis2ToProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('avis_chefdezone_appui2',100)->nullable();
            $table->text('observation_chefdezone_appui2')->nullable();
            $table->string('avis_ugp_appui2',100)->nullable();
            $table->text('observation_ugp_appui2')->nullable();
            $table->string('statut_appui2',70)->nullable();
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
           
        });
    }
}
