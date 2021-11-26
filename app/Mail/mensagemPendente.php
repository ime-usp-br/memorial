<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mensagemPendente extends Mailable
{
    use Queueable, SerializesModels;
    private $msg, $user, $homenageado, $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $homenageado, $user, $token)
    {
        $this->msg = $mensagem;
        $this->user = $user;
        $this->homenageado = $homenageado;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("[ IME-USP ] Nova mensagem pendente no memorial para {$this->homenageado->nome}");
        $this->to($this->user->email, $this->user->name);
        //$this->bcc("webmaster@ime.usp.br", "WebMaster");
        return $this->view('mail.mensagemPendente', [
            'mensagem' => $this->msg,
            'homenageado' => $this->homenageado,
            'token' => $this->token,
        ]);
    }
}
