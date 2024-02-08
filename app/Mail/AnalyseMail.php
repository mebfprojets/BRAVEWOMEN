<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Facture;
use App\Models\Devi;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class AnalyseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $msg;
    public $view;
    public $id_elmt;
    public $type_elmet;



    public function __construct($titre, $message, $view, $elmt, $typ_elmet)
    {
        $this->name = $titre;
        $this->msg = $message;
        $this->view = $view;
        $this->id_elmt = $elmt;
        $this->type_elmet = $typ_elmet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // dd($e_type_elmet);
        $e_nom = $this->name;
        $e_msg = $this->msg;
        $e_view = $this->view;
        $e_type_elmet= $this->type_elmet;
        $e_id_elmt = $this->id_elmt;
        if($e_type_elmet=='devi')
        {
            $element= Devi::find($e_id_elmt);
        }
        else
        {
            $element= Facture::find($e_id_elmt);
        }
        $baseUrl = URL::to('/');
        $url= $baseUrl.'/'.$e_type_elmet.'/'.$element->slug.'?action=analyser';
        return $this->view($e_view, compact('e_msg', 'e_nom','element','url'))->subject(env('OBJET_ANALYSE_DEVIS'));
    }
}
