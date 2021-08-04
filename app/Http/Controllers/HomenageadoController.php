<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomenageadoRequest;
use App\Models\Foto;
use App\Models\Homenageado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
        if(!Gate::allows('administrador')) return redirect('/');

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
    public function store(HomenageadoRequest $request)
    {
        if(!Gate::allows('administrador')) return redirect('/');

        $validated = $request->validated();
        $homenageado = [];
        $homenageado['nome'] = $validated['nome'];
        $homenageado['data_nascimento'] = $validated['data_nascimento'];
        $homenageado['data_falecimento'] = $validated['data_falecimento'];
        $homenageado['biografia'] = $validated['biografia'];
        $homenageado = Homenageado::create($homenageado);

        //salvando a foto de perfil
        $foto_perfil = [];
        $foto_perfil['homenageado_id'] = $homenageado->id;
        if($request->foto_perfil != null) $foto_perfil['caminho'] = $request->file('foto_perfil')->store('.');
        else $foto_perfil['caminho'] = '';
        $foto_perfil['foto_perfil'] = true;
        $foto_perfil = Foto::create($foto_perfil);
        
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
        $fotoPerfil = $homenageado->fotoPerfil($homenageado->id);
        return view('homenageados.show', [
            'homenageado' => $homenageado,
            'fotoPerfil' => $fotoPerfil
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
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$homenageado->id])) return redirect("/homenageados/$homenageado->id");

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
    public function update(HomenageadoRequest $request, Homenageado $homenageado)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$homenageado->id])) return redirect("/homenageados/$homenageado->id");

        $validated = $request->validated();
        $updateHomenageado = [];
        $updatehomenageado['nome'] = $validated['nome'];
        $updatehomenageado['data_nascimento'] = $validated['data_nascimento'];
        $updatehomenageado['data_falecimento'] = $validated['data_falecimento'];
        $updatehomenageado['biografia'] = $validated['biografia'];
       
        $fotoPerfil = $homenageado->fotoPerfil($homenageado->id);
        $novaFotoPerfil = [];
        
        $novaFotoPerfil['foto_perfil'] = true;
        $novaFotoPerfil['homenageado_id'] = $homenageado->id;
        if($request->foto_perfil != null){
            $novaFotoPerfil['caminho'] = $request->file('foto_perfil')->store('.');
            Storage::delete($fotoPerfil->caminho); // deletar foto de perfil antiga
        }
        else $novaFotoPerfil['caminho'] = $fotoPerfil->caminho; 
        
        $fotoPerfil->update($novaFotoPerfil);
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
        if(!Gate::allows('administrador')) return redirect("/homenageados/$homenageado->id");
        
        foreach($homenageado->fotos as $foto){
            Storage::delete($foto->caminho);
        }
        $homenageado->fotos()->delete();
        $homenageado->mensagens()->delete();
        $homenageado->delete();
        return redirect("/");
    }
}
