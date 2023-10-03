<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatePaiementColumnToFacture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->string('url_recu_paiement')->nullable();
            $table->date('date_de_validation')->nullable();
            $table->date('date_de_paiement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
           $table->dropColumn('url_recu_paiement');
           $table->dropColumn('date_de_validation');
           $table->dropColumn('date_de_paiement');


        });
    }
}
