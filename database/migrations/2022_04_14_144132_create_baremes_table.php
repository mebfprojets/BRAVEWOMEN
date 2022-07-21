<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaremesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baremes', function (Blueprint $table) {
            $table->id();
            //identifiante de valeur pour avoir id critere
            $table->integer("valeur_id");
            $table->integer("valeur_inf");
            $table->integer("valeur_sup");
            $table->integer("note");
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
        Schema::dropIfExists('baremes');
    }
}
