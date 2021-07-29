<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemRequest;
use App\Models\Mensagem;

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
    public function store(MensagemRequest $request)
    {
        $validated = $request->validated();
        $msg = Mensagem::create($validated);
        request()->session()->flash('Mensagem criada com sucesso!');
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
    public function update(MensagemRequest $request, Mensagem $mensagem)
    {
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
    public function destroy(Mensagem $mensagem)
    {
        $homenageado_id = $mensagem->homenageado_id;
        $mensagem->delete();
        return redirect("/homenageados/$homenageado_id");
    }
}
