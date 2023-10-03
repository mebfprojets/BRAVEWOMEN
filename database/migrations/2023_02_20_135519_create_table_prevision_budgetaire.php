<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrevisionBudgetaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prevision_budgetaires', function (Blueprint $table) {
            $table->id();
            $table->date('date_effet')->nullable();
            $table->string('activite')->nullable();
            $table->double('montant_depense');
            $table->double('montant_budgetise');
            $table->double('prevision_mois_n');
            $table->double('prevision_mois_n1');
            $table->double('prevision_mois_n2');
            $table->double('prevision_mois_n3');
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
        Schema::dropIfExists('prevision_budgetaires');
    }
}
