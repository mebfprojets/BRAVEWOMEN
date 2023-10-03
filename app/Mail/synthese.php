<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\Evaluation;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;
use App\Models\Promotrice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class synthese extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $id_entreprise;

    public function __construct($id)
    {
        $this->id_entreprise = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id_entreprise = $this->id_entreprise;
        $entreprise= Entreprise::where("id", $id_entreprise)->first();
       // $promoteur= Promotrice::where("id", $id_promo)->first();
       // $membre_comites= User::where('structure_represente','!=',0)->where('structure_represente','!=',null)->get();
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $evaluations= Evaluation::where('entreprise_id', $id_entreprise)->get();
        $resume = PDF::loadView('pdf.synthese', compact('entreprise','effectif_permanent_entreprises','benefice_nets','produit_vendus','chiffre_daffaire','effectif_temporaire_entreprises',"evaluations"));
        $details['code_promoteur'] = $entreprise->promotrice->code_promoteur;
        $details['entreprise'] = $entreprise->denomination;
        return $this->view('mails.synthese_candidature',compact('details'))->attachData($resume->output(), "resume.pdf");
    }
}
