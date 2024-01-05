<?php

namespace App\Mail;

use App\Models\Entreprise;
use App\Models\Promotrice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        $data["email"] = $promoteur->email_promoteur;
        $this->email= $promoteur->email_promoteur;
        $qrcode =  base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate("Ceci est un recepissé généré par la plateforme BRAVE WOMEN Burkina"."Code didentification:"." ".$promoteur->code_promoteur."_".$promoteur->id."BWBF"));
        $pdf = PDF::loadView('pdf.recepisse', compact('promoteur','entreprise','qrcode'));
        $details['email'] = $promoteur->email;
        $details['nom'] = $promoteur->nom;
        $details['prenom'] = $promoteur->prenom;
       // dd($qrcode);
        return $this->view('recepisse',compact('details'))->attachData($pdf->output(), "recépissé.pdf");
    }
}
