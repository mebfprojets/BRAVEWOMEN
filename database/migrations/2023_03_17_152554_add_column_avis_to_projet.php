<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAvisToProjet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('avis_ugp')->nullable();
            $table->string('observation_ugp')->nullable();
            $table->string('avis_chefdezone')->nullable();
            $table->string('observation_chefdezone')->nullable();
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
            $table->dropColumn('avis_ugp');
            $table->dropColumn('avis_chefdezone');
            $table->dropColumn('observation_chefdezone');
            $table->dropColumn('observation_ugp');
        });
    }
}
