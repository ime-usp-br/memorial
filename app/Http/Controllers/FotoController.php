<?php

namespace App\Http\Controllers;

use App\Http\Requests\FotoRequest;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

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
        $validated['caminho'] = $request->file('foto')->store('.');
        $validated['foto_perfil'] = false;
        $foto = Foto::create($validated);
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
        $validated['caminho'] = $request->file('foto')->store('.');
        $validated['foto_perfil'] = false;
        
        //deletar a foto antiga 
        Storage::delete($foto->caminho);

        $foto->update($validated);
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
        return redirect("/homenageados/$homenageado_id");
    }
}
