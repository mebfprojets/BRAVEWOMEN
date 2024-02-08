<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Facture;
use App\Models\Devi;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class ReinitialiseMail extends Mailable
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



    public function __construct($titre, $message, $view)
    {
        $this->name = $titre;
        $this->msg = $message;
        $this->view = $view;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_nom = $this->name;
        $e_msg = $this->msg;
        $e_view = $this->view;
        return $this->view($e_view, compact('e_msg', 'e_nom'))->subject(env('MESSAGE_REINITIALISE'));
    }
}
