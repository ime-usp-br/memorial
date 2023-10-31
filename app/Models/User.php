<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Spatie\Permission\Traits\HasRoles;
use \Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function homenageados(){
        return $this->belongsToMany(Homenageado::class, 'curadores');
    }   

    public function tokens(){
        return $this->belongsToMany(Mensagem::class, 'tokens')->withPivot(['token', 'expires_in']);
    }

    public function souCuradorHomenageado($homenageado_id){
        foreach($this->homenageados as $homenageado){
            if($homenageado->id == $homenageado_id){
                return true;
            }
        }
        return false;
    }

    public function roles(){
        return [
            'administrador',
            'curador',
            'none'
        ];
    }

    public function admins(){
        return User::select('*')->where('role','=','administrador')->get();
    }
}
