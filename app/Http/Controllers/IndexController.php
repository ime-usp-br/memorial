<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homenageado;

class IndexController extends Controller
{
    public function index()
    {   
        $homenageados = Homenageado::select('*')->get();
        return view('homenageados.index', [
            'homenageados' => $homenageados
        ]);
    }
}
