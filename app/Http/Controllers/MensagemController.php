<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemRequest;
use App\Mail\mensagemPendente;
use App\Mail\mensagemWebMaster;
use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\Homenageado;
use Illuminate\Support\Facades\Auth;

class MensagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $msg = new Mensagem;
        return view('mensagens.create', [
            'mensagem' => $msg,
            'homenageado_id' => $id,
            'edit' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MensagemRequest $request)
    {
        $validated = $request->validated();
        $msg = Mensagem::create($validated);
        $user = new User;
        $homenageado = Homenageado::find($msg->homenageado_id);

        //apenas manda email se não for curador ou admin
        //c.c, já coloca a mensagem como aprovada
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$msg->homenageado_id])) Mail::send(new mensagemPendente($msg, $homenageado, $user->admins(),$homenageado->curadores()));
        else{
            $msg->estado = "APROVADO";
            $msg->save();
        }
        request()->session()->flash('alert-info', 'Mensagem aguardando validação');
        return redirect("/homenageados/$msg->homenageado_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function show(Mensagem $mensagem)
    {
        return view('mensagens.show', [
            'mensagem' => $mensagem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensagem $mensagem)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$mensagem->homenageado_id])) return redirect("/homenageados/$mensagem->homenageado_id");
        
        return view('mensagens.edit', [
            'mensagem' => $mensagem,
            'homenageado_id' => $mensagem->homenageado_id,
            'edit' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function update(MensagemRequest $request, Mensagem $mensagem)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$mensagem->homenageado_id])) return redirect("/homenageados/$mensagem->homenageado_id");

        $validated = $request->validated();

        $mensagem->update($validated);
        request()->session()->flash('Mensagem atualizada com sucesso!');
        return redirect("/homenageados/$mensagem->homenageado_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function delete($mensagem_id){
        $msg = Mensagem::find($mensagem_id);
        $homenageado_id = $msg->homenageado_id;
        $this->destroy($msg);
        return redirect("/homenageados/$homenageado_id");
    }

    public function destroy(Mensagem $mensagem)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$mensagem->homenageado_id])) return redirect("/homenageados/$mensagem->homenageado_id");
        
        $mensagem->delete();   
    }

    public function formValidarMensagem($msg_id){
        $mensagem = Mensagem::find($msg_id);
        return view('mensagens.validarMensagem',[
            'mensagem' => $mensagem
        ]);
    }

    public function validarMensagem($msg_id, $validacao){
        $mensagem = Mensagem::find($msg_id);
        $homenageado_id = $mensagem->homenageado_id;
        if($validacao == 'deletar') $mensagem->delete();
        else if($validacao == 'aceitar'){  
            $mensagem->estado = 'APROVADO';
            $mensagem->save();
        }
        else{
            $mensagem->estado = 'NEGADO';
            $mensagem->save();
        } 
        return redirect("/homenageados/$homenageado_id");
    }

    public function mandarWebMaster($msg_id){
        $msg = Mensagem::find($msg_id);
        Mail::send(new mensagemWebMaster($msg));
        return back();
    }
}
