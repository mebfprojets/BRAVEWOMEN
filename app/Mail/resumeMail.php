<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;
use App\Models\Promotrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class resumeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $id_promoteur;

    public function __construct($id)
    {
        $this->id_promoteur = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id_promo = $this->id_promoteur;
        $promoteur= Promotrice::where("id", $id_promo)->first();
        $entreprise= Entreprise::where("code_promoteur", $promoteur->code_promoteur)->orderBy('created_at','desc')->first();
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_BENEFICE_NET"))->get();
        $projet= $entreprise->projet;
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        $resume = PDF::loadView('pdf.resume', compact('promoteur','entreprise','effectif_permanent_entreprises','benefice_nets','produit_vendus','chiffre_daffaire','effectif_temporaire_entreprises'));
        $details['email'] = $promoteur->email;
        $details['nom'] = $promoteur->nom;
        $details['prenom'] = $promoteur->prenom;
        return $this->view('recepisse',compact('details'))->attachData($resume->output(), "resume.pdf");
    }
}
