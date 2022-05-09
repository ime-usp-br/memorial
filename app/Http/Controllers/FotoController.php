<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoRequest;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($homenageado_id)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$homenageado_id])) return redirect("/homenageados/$homenageado_id");

        $foto = new Foto();
        return view('fotos.create', [
            'foto' => $foto,
            'homenageado_id' => $homenageado_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FotoRequest $request)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$request->homenageado_id])) return redirect("/homenageados/$request->homenageado_id");

        $validated = $request->validated();
        $validated['foto_perfil'] = false;
        $countFotos = 0;
        foreach($request['fotos'] as $foto){
            $countFotos++;
            $validated['caminho'] = $foto->store('.');
            $foto = Foto::create($validated);
        }
        if($countFotos > 1) $request->session()->flash('alert-info','Fotos enviadas com sucesso.');
        else $request->session()->flash('alert-info','Foto enviada com sucesso.');
        
        return redirect("/homenageados/$foto->homenageado_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function show(Foto $foto)
    {
        return Storage::download($foto->caminho, null, [$foto->descricao]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function edit(Foto $foto)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$foto->homenageado_id])) return redirect("/homenageados/$foto->homenageado_id");
        return view('fotos.edit', [
            'foto' => $foto,
            'homenageado_id' => $foto->homenageado_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function update(FotoRequest $request, Foto $foto)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$foto->homenageado_id])) return redirect("/homenageados/$foto->homenageado_id");

        $validated = $request->validated();
        $novaFoto = $request['fotos'][0];
        $validated['caminho'] = $novaFoto->store('.');
        $validated['foto_perfil'] = false;
        
        //deletar a foto antiga 
        Storage::delete($foto->caminho);

        $foto->update($validated);
        $request->session()->flash('alert-info','Foto atualizada com sucesso.');
        return redirect("/homenageados/$foto->homenageado_id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foto $foto)
    {
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$foto->homenageado_id])) return redirect("/homenageados/$foto->homenageado_id");
        
        $homenageado_id = $foto->homenageado_id;
        Storage::delete($foto->caminho);
        $foto->delete();
        request()->session()->flash('alert-info','Foto excluída com sucesso.');
        return redirect("/homenageados/$homenageado_id");
    }

    public function atualizaDescricao(Request $request){
        $foto = Foto::find($request->foto_id);
        if(!Gate::allows('administrador') && !Gate::allows('curador', [$foto->homenageado_id])) return redirect("/homenageados/$foto->homenageado_id");

        $foto->descricao = $request['descricao'];
        $foto->save();
        request()->session()->flash('alert-info','Descrição editada com sucesso.');
        return redirect("/homenageados/$foto->homenageado_id");
    }
}
