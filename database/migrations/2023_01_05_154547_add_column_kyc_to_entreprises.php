<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKycToEntreprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->date('date_demande_kyc')->nullable();
            $table->date('date_realisation_kyc')->nullable();
            $table->string('resultat_kyc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn('date_demande_kyc');
            $table->dropColumn('date_realisation_kyc');
            $table->dropColumn('resultat_kyc');
        });
    }
}
