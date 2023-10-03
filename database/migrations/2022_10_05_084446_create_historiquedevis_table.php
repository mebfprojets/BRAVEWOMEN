<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriquedevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiquedevis', function (Blueprint $table) {
            $table->id();
            $table->integer('devis_id');
            $table->integer('user_id');
            $table->string('statut');
            $table->integer('motif')->nullable();
            $table->text('observation')->nullable();
            $table->date('date_statut');
            $table->date('date_changestatut')->nullable();
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
        Schema::dropIfExists('historiquedevis');
    }
}
