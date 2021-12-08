<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Homenageado;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function showAdmins(){
        if(!Gate::allows('administrador')) return redirect('/');
        $user = new User;
        $admins = $user->admins();
        return view('users.admin', [
            'admins' => $admins
        ]);
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
        return redirect('/admin');
    }

    public function removerAdmin($admin_id){
        if(!Gate::allows('administrador')) return redirect()->back();

        $user = User::find($admin_id);
        $user->role = 'none';

        $user->save();
        return redirect('/admin');
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

        $homenageado = Homenageado::find($request->homenageado_id);

        if($user->role == 'administrador'){
            $request->session()->flash('alert-info','Este usuário já tem permissão de administrador.');
        }
        else if($user->souCuradorHomenageado($request->homenageado_id)){
            $request->session()->flash('alert-info','Este usuário já é curador desse homenageado.');
        }
        else{
            $user->codpes = $request->codpes;
            $user->name = \Uspdev\Replicado\Pessoa::nomeCompleto($request->codpes);
            $user->email = \Uspdev\Replicado\Pessoa::email($request->codpes);
            $user->role = 'curador';
            $user->save();
            $user->homenageados()->attach($homenageado);
        }

        return redirect("/homenageados/{$homenageado->id}/curadoria");
    }

    public function showHomenageadosCurador($curador_codpes){
        $curador = User::where('codpes',$curador_codpes)->first();
        return view('users.curadores.homenageados', [
            'curador' => $curador
        ]);
    }


    public function removerCurador($curador_id, $homenageado_id){
        if(!Gate::allows('administrador')) return redirect("/homenageados/$homenageado_id");

        $user = User::find($curador_id);
        $homenageado = Homenageado::find($homenageado_id);

        $homenageado->curadores()->detach($user);
        $user->role = 'none';

        $user->save();
        return redirect("/homenageados/$homenageado_id");
    }
}
