<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomenageadoRequest;
use App\Models\Foto;
use App\Models\Homenageado;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {   
        if(isset($request->search)){
            $homenageados = Homenageado::where('nome','LIKE',"%{$request->search}%")->paginate(10);
        }
        else{
            $homenageados = Homenageado::paginate(10);
            
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

        if($validated['data_nascimento'] == null)
            $homenageado['data_nascimento'] = null;
        else
            $homenageado['data_nascimento'] = DateTime::createFromFormat('d/m/Y', $validated['data_nascimento'])->format('Y-m-d');

        if($validated['data_falecimento'] == null)
            $homenageado['data_falecimento'] = null;
        else
            $homenageado['data_falecimento'] = DateTime::createFromFormat('d/m/Y', $validated['data_nascimento'])->format('Y-m-d');

        $homenageado['funcao'] = $validated['funcao'];
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
        $fotoPerfil = $homenageado->fotoPerfil($homenageado->id);
        $fotos = [];
        $count = 0;
        foreach($homenageado->fotos as $foto){
            if(!$foto->foto_perfil) $fotos[$count++] = $foto;
        } 
        return view('homenageados.show', [
            'homenageado' => $homenageado,
            'fotoPerfil' => $fotoPerfil,
            'fotos' => $fotos
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
        $updateHomenageado['nome'] = $validated['nome'];

        if($validated['data_nascimento'] == null)
            $updateHomenageado['data_nascimento'] = null;
        else
            $updateHomenageado['data_nascimento'] = DateTime::createFromFormat('d/m/Y', $validated['data_nascimento'])->format('Y-m-d');

        if($validated['data_falecimento'] == null)
            $updateHomenageado['data_falecimento'] = null;
        else
            $updateHomenageado['data_falecimento'] = DateTime::createFromFormat('d/m/Y', $validated['data_falecimento'])->format('Y-m-d');
        
        $updateHomenageado['funcao'] = $validated['funcao'];
        $updateHomenageado['biografia'] = $validated['biografia'];
       
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

    public function delete($homenageado_id){
        $homenageado = Homenageado::find($homenageado_id);
        $this->destroy($homenageado);
        return redirect("/");
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
        foreach($homenageado->curadores as $curador){
            $homenageado->curadores()->detach($curador);
        }
        $homenageado->delete();

    }
}
