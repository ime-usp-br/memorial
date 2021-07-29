<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homenageado;

class IndexController extends Controller
{
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
}
