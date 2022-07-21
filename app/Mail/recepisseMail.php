<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\Promotrice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class recepisseMail extends Mailable
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
        $projet= $entreprise->projet;
        $chef_de_zone= User::where("zone",$entreprise->region)->first();
        $contact_chef_de_zone= $chef_de_zone->telephone ;
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        $pdf = PDF::loadView('pdf.recepisse', compact('promoteur','entreprise','projet', 'contact_chef_de_zone'));
        $details['email'] = $promoteur->email;
        $details['nom'] = $promoteur->nom;
        $details['prenom'] = $promoteur->prenom;
        return $this->view('recepisse',compact('details'))->attachData($pdf->output(), "recépissé.pdf");
    }
}
