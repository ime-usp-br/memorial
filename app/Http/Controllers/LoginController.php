<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    protected $redirectTo = '/';

    public function redirectToProvider()
    {
        return Socialite::driver('senhaunica')->redirect();
    }

    public function handleProviderCallback()
    {
        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        // $admins = explode(',', trim(env('SENHAUNICA_ADMINS')));
        
        // if(!in_array($userSenhaUnica->codpes, $admins)){
        //     request()->session()->flash('alert-danger', 'Você não tem permissão de login');
        //     return redirect('/');
        // } 
        
        $user = User::where('codpes', $userSenhaUnica->codpes)->first();
        if ($user == null) $user = new User;

        $user->codpes = $userSenhaUnica->codpes;
        $user->email = $userSenhaUnica->email;
        $user->name = $userSenhaUnica->nompes;
        $user->save();

        // bind do dados retornados
        Auth::login($user, true);
        
        if($user->role == 'curador') return redirect("/curador/homenageados/$user->codpes");

        return redirect('/');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}