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
    private $msg, $admins, $curadores, $homenageado;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $homenageado, $admins, $curadores)
    {
        $this->msg = $mensagem;
        $this->admins = $admins;
        $this->curadores = $curadores;
        $this->homenageado = $homenageado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("Nova mensagem pendente para o homenageado {$this->homenageado->nome}");
        foreach($this->admins as $admin){
            $this->to($admin->email, $admin->name);
        }
        foreach($this->curadores as $curador){
            if($curador) $this->to($curador->email, $curador->name);
        }
        $this->bcc("webmaster@ime.usp.br", "WebMaster");
        return $this->view('mail.mensagemPendente', [
            'msg' => $this->msg,
            'homenageado' => $this->homenageado
        ]);
    }
}
