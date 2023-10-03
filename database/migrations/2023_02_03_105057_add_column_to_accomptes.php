<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAccomptes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accomptes', function (Blueprint $table) {
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
        Schema::table('accomptes', function (Blueprint $table) {
            $table->dropColumn('creerPar');
            $table->dropColumn('modfierPar');

        });
    }
}
