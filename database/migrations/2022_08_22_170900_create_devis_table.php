<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->text('designation');
            $table->String('slug')->unique();
            $table->string('numero_devis')->nullable();
            $table->string("copie_fiche_analyse");
            $table->integer("prestataire_id");
            $table->string("nom_bank_prestataire")->nullable();
            $table->string("compte_bank_prestataire")->nullable();
            $table->string("copie_devis_prefere");
            $table->bigInteger('montant_devis');
            $table->bigInteger('montant_avance');
            $table->integer("entreprise_id");
            $table->integer("motif_du_rejet")->nullable();
            $table->text("observation")->nullable();
            $table->integer("user_id");
            $table->string('statut');
            $table->string("copie_devis_1");
            $table->string("copie_devis_2");
            $table->integer('nombre_de_paiement')->nullable();
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
        Schema::dropIfExists('devis');
    }
}
