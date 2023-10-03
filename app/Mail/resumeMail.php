<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\Infoeffectifentreprise;
use App\Models\Infoentreprise;
use App\Models\Promotrice;
use App\Models\Proportion_de_depense_promotrice;
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
        $promoteur= Promotrice::find($id_promo);
        $entreprise= Entreprise::where("code_promoteur", $promoteur->code_promoteur)->orderBy('created_at','desc')->first();
        $effectif_permanent_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_PERMANENENT"))->get();
        $effectif_temporaire_entreprises= Infoeffectifentreprise::where("entreprise_id",$entreprise->id)->where("effectif",env("VALEUR_EFFECTIF_TEMPORAIRE"))->get();
        $chiffre_daffaire= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_CHIFFRE_D_AFFAIRE"))->get();
        $produit_vendus= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_PRODUIT_VENDU"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_BENEFICE_NET"))->get();
        $benefice_nets= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_BENEFICE_NET"))->get();
        $nombre_de_clients= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_NOMBRE_CLIENT"))->get();
        $salaire_moyen_annuels= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_SALAIRE_MOYEN_ANNUEL"))->get();
        $nombre_dinnovations= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_ID_NOMBRE_INNOVATION"))->get();
        $nombre_nouveau_marches= Infoentreprise::where("entreprise_id",$entreprise->id)->where("indicateur",env("VALEUR_ID_NOMBRE_NOUVEAU_MARCHE"))->get();
        $proportion_de_depense_education= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_EDUCATION") )->get();
        $proportion_de_depense_sante= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_SANTE"))->get();
        $proportion_de_depense_bien_materiel= Proportion_de_depense_promotrice::where("promotrice_id",$entreprise->promotrice->id)->where('proportion_id',env("VALEUR_PROPORTION_BIEN"))->get();
       // $projet= $entreprise->projet;
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        $resume = PDF::loadView('pdf.resumeaop', compact('promoteur','entreprise','effectif_permanent_entreprises','benefice_nets','produit_vendus','chiffre_daffaire','effectif_temporaire_entreprises','nombre_de_clients','salaire_moyen_annuels','nombre_dinnovations','nombre_nouveau_marches','proportion_de_depense_education','proportion_de_depense_sante','proportion_de_depense_bien_materiel'));
        $details['email'] = $promoteur->email;
        $details['nom'] = $promoteur->nom;
        $details['prenom'] = $promoteur->prenom;
        return $this->view('resume_mail',compact('details'))->attachData($resume->output(), "resume.pdf");
    }
}
