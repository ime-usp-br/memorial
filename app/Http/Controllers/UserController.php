<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Homenageado;

class UserController extends Controller
{
    public function formAdmin(){
        if(!Gate::allows('administrador')) return redirect('/');
        
        return view('users.novoadmin');
    }

    public function registerAdmin(Request $request){
        if(!Gate::allows('administrador')) return redirect('/');

        $request->validate([
            'codpes' => 'required|integer|codpes',
        ]);
        $user = User::where('codpes',$request->codpes)->first();
        if(!$user) $user = new User;

        $user->codpes = $request->codpes;
        $user->name = \Uspdev\Replicado\Pessoa::nomeCompleto($request->codpes);
        $user->email = \Uspdev\Replicado\Pessoa::email($request->codpes);
        $user->role = 'administrador';
        $user->save();
        return redirect('/');
    }

    public function formCurador($homenageado_id){
        if(!Gate::allows('administrador')) return redirect("/homenageados/$homenageado_id");

        return view('users.novocurador', [
            'homenageado_id' => $homenageado_id
        ]);
    }

    public function registerCurador(Request $request){
        if(!Gate::allows('administrador')) return redirect('/');

        $request->validate([
            'codpes' => 'required|integer|codpes',
        ]);
        $user = User::where('codpes',$request->codpes)->first();
        if(!$user) $user = new User;

        $user->codpes = $request->codpes;
        $user->name = \Uspdev\Replicado\Pessoa::nomeCompleto($request->codpes);
        $user->email = \Uspdev\Replicado\Pessoa::email($request->codpes);
        $user->role = 'curador';

        $user->save();
        $homenageado = Homenageado::select('*')->where('homenageados.id', '=',$request->homenageado_id)->get();

        $user->homenageados()->attach($homenageado);

        return redirect("/homenageados/{$homenageado[0]->id}");
    }
}
