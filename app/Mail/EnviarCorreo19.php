<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo19 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $cedula;
    public $nombrepagare;
    public $idposicionpagare;
    public $capital;
    public $idpagare;
    public $agencia;




    public function __construct($cedula, $idpagare, $capital, $idposicionpagare, $nombrepagare, $agencia)
    {
        $this->cedula = $cedula;
        $this->nombrepagare = $nombrepagare;
        $this->idposicionpagare = $idposicionpagare;
        $this->capital = $capital;
        $this->idpagare = $idpagare;
        $this->agencia = $agencia;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '¡PAGARE APROBADO!',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'Mails.enviar-correo19',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
