<?php

namespace App\Http\Controllers;

use App\Models\Homenageado;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;


class HomenageadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $homenageados = Homenageado::select('*')->get();
        foreach($homenageados as $homenageado){
            $homenageado->formatData($homenageado);
        }
        return view('homenageados.index', [
            'homenageados' => $homenageados
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('homenageados.create', [
            'homenageado' => new Homenageado
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
        $homenageado = [];
        $homenageado['nome'] = $request->nome;
        $homenageado['data_nascimento'] = $request->data_nasc;
        $homenageado['data_falecimento'] = $request->data_fale;
        $homenageado['biografia'] = $request->bio;
        $homenageado = Homenageado::create($homenageado);
        return redirect("/homenageados/$homenageado->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homenageado  $homenageado
     * @return \Illuminate\Http\Response
     */
    public function show(Homenageado $homenageado)
    {
        $homenageado->formatData($homenageado);
        return view('homenageados.show', [
            'homenageado' => $homenageado
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homenageado  $homenageado
     * @return \Illuminate\Http\Response
     */
    public function edit(Homenageado $homenageado)
    {
        $homenageado->formatData($homenageado);
        return view('homenageados.edit', [
            'homenageado' => $homenageado
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Homenageado  $homenageado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homenageado $homenageado)
    {
        $updateHomenageado = [];
        $updateHomenageado['nome'] = $request->nome;
        $updateHomenageado['data_nascimento'] = $request->data_nasc;
        $updateHomenageado['data_falecimento'] = $request->data_fale;
        $updateHomenageado['biografia'] = $request->bio;
        $homenageado->update($updateHomenageado);
        return redirect("/homenageados/{$homenageado->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homenageado  $homenageado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homenageado $homenageado)
    {
        $homenageado->delete();
        return redirect("/");
    }
}
