<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $msg;
    public $telephone;
    public $view;

    public function __construct($nom, $message, $telephone, $view)
    {
        $this->name = $nom;
        $this->msg = $message;
        $this->telephone = $telephone;
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
        $e_tel = $this->telephone;
        $e_view = $this->view;
        return $this->view($e_view, compact('e_msg', 'e_nom', 'e_tel'))->subject(env('OBJET_ASSISTANCE'));
    }
}
