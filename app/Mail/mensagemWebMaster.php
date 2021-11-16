<?php

namespace App\Mail;

use App\Models\Homenageado;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mensagemWebMaster extends Mailable
{
    use Queueable, SerializesModels;
    private $msg, $homenageado;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem)
    {
        $this->msg = $mensagem;
        $this->homenageado = Homenageado::find($mensagem->homenageado_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("Nova mensagem pendente para o homenageado {$this->homenageado->nome}");
        $this->to("webmaster@ime.usp.br", "webmaster");
        return $this->view('mail.mensagemPendente', [
            'msg' => $this->msg,
            'homenageado' => $this->homenageado
        ]);
    }
}
