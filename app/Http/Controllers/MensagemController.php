<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

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
            'homenageado_id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = [];
        $msg['nome'] = $request->nome;
        $msg['email'] = $request->email;
        $msg['instituicao'] = $request->instituicao;
        $msg['mensagem'] = $request->msg;
        $msg['homenageado_id'] = $request->homenageado_id;
        $msg = Mensagem::create($msg);
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
        return view('mensagens.edit', [
            'mensagem' => $mensagem,
            'homenageado_id' => $mensagem->homenageado_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensagem $mensagem)
    {
        $novaMsg = [];
        $novaMsg['nome'] = $request->nome;
        $novaMsg['email'] = $request->email;
        $novaMsg['instituicao'] = $request->instituicao;
        $novaMsg['mensagem'] = $request->msg;
        $novaMsg['homenageado_id'] = $request->homenageado_id;
        $mensagem->update($novaMsg);
        return redirect("/homenageados/$mensagem->homenageado_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensagem $mensagem)
    {
        $homenageado_id = $mensagem->homenageado_id;
        $mensagem->delete();
        return redirect("/homenageados/$homenageado_id");
    }
}
