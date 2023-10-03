<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSubventions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subventions', function (Blueprint $table) {
            $table->string('creerPar')->nullable();
            $table->string('modfierPar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subventions', function (Blueprint $table) {
            $table->dropColumn('creerPar');
            $table->dropColumn('modfierPar');
        });
    }
}
