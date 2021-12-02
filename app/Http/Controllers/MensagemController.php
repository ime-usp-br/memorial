<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemRequest;
use App\Mail\mensagemPendente;
use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\Homenageado;
use DateTime;
use Illuminate\Support\Facades\Auth;
use PhpParser\Parser\Tokens;
use Carbon\Carbon;

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
        $this->validate($request, [
            'CaptchaCode'=> 'required|valid_captcha'
        ], [
            'CaptchaCode.required' => 'O Captcha é obrigatório.',
            'CaptchaCode.valid_captcha' => 'Texto do captcha inválido. Tente novamente.',
        ]);
        $validated = $request->validated();
        $msg = Mensagem::create($validated);
        $user = new User;
        $homenageado = Homenageado::find($msg->homenageado_id);

        //apenas manda email se não for curador ou admin
        //c.c, já coloca a mensagem como aprovada
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$msg->homenageado_id])){
            foreach($user->admins() as $admin){
                $token = sha1(time()); //criação do token
                $expireDate = Carbon::now('America/Sao_Paulo')->addDays(2); //data de expiração do token
                $admin->tokens()->attach($msg, array('token' => $token, 'expires_in' => $expireDate));
                Mail::send(new mensagemPendente($msg, $homenageado, $admin, $token));
            }
            foreach($homenageado->curadores as $curador){
                $token = sha1(time());
                $expireDate = Carbon::now('America/Sao_Paulo')->addDays(2);
                $curador->tokens()->attach($msg, array('token' => $token, 'expires_in' => $expireDate));
                Mail::send(new mensagemPendente($msg, $homenageado, $curador, $token));
            }
        }
        else{
            $msg->estado = "APROVADO";
            $msg->tipo_aprovacao = 'CRIADA POR RESPONSÁVEL';
            $msg->aprovador_id = Auth::user()->id;
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
        if($mensagem->estado != 'APROVADO' && $validated['estado'] == 'APROVADO'){
            $validated['tipo_aprovacao'] = 'EDIÇÃO';
            $validated['aprovador_id'] = Auth::user()->id;
        }

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
        foreach($msg->tokens as $tokenMsg){
            $msg->tokens()->detach($tokenMsg);
        }
        $this->destroy($msg);
        return redirect("/homenageados/$homenageado_id");
    }

    public function destroy(Mensagem $mensagem)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$mensagem->homenageado_id])) return redirect("/homenageados/$mensagem->homenageado_id");
        
        $mensagem->delete();   
    }

    public function validarMensagem($msg_id, $token, $validacao){
        $mensagem = Mensagem::find($msg_id);
        $achou = false;
        $aprovador_id = -1;
        foreach($mensagem->tokens as $tokenSalvo){
            if($tokenSalvo->pivot->token == $token){
                $achou = true;
                $aprovador_id = $tokenSalvo->id; //$tokenSalvo na verdade é um user
                break;
            }
        }
        $homenageado_id = $mensagem->homenageado_id;
        if($validacao == 'aceitar'){  
            if($achou){
                
                $mensagem->estado = 'APROVADO';
                $mensagem->tipo_aprovacao = 'TOKEN';
                $mensagem->aprovador_id = $aprovador_id;
                $mensagem->save();
                foreach($mensagem->tokens as $tokenMsg){
                    $mensagem->tokens()->detach($tokenMsg);
                }
                request()->session()->flash('alert-info', 'Mensagem aprovada.');
            }
            else{
                request()->session()->flash('alert-danger', 'Token inválido!');
            }
        }
        else{
            if($achou){
                request()->session()->flash('alert-info', 'Mensagem negada.');
                $mensagem->estado = 'NEGADO';
                $mensagem->save();
            }
            else{
                request()->session()->flash('alert-danger', 'Token inválido!');
            }
        }
        return redirect("/homenageados/$homenageado_id");
    }

}
