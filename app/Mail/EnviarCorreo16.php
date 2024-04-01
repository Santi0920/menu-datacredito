<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo16 extends Mailable
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
    public $score;
    public $fechaconsulta;



    public function __construct($cedula, $idpagare, $capital, $idposicionpagare, $nombrepagare, $agencia, $score, $fechaconsulta)
    {
        $this->cedula = $cedula;
        $this->nombrepagare = $nombrepagare;
        $this->idposicionpagare = $idposicionpagare;
        $this->capital = $capital;
        $this->idpagare = $idpagare;
        $this->agencia = $agencia;
        $this->score = $score;
        $this->fechaconsulta = $fechaconsulta;

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
            view: 'Mails.enviar-correo16',
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
