<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        $request->validate([
            'homenageado_id' => 'required|integer|exists:homenageados,id',
            'foto' => 'required|file|image|'
        ]);
        
        $foto = [];
        $foto['homenageado_id'] = $request->homenageado_id;
        $foto['caminho'] = $request->file('foto')->store('.');
        $foto['descricao'] = $request->desc;
        $foto['foto_perfil'] = false;
        $foto = Foto::create($foto);
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
    public function update(Request $request, Foto $foto)
    {
        $newFoto = [];
        $newFoto['caminho'] = $request->file('foto')->store('.');
        $newFoto['homenageado_id'] = $request->homenageado_id;
        $newFoto['descricao'] = $request->desc;
        $newFoto['foto_perfil'] = false;
        $foto->update($newFoto);
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
        $homenageado_id = $foto->homenageado_id;
        Storage::delete($foto->caminho);
        $foto->delete();
        return redirect("/homenageados/$homenageado_id");
    }
}
