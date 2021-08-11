<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Homenageado extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function fotoPerfil($id){
        return Foto::select('*')->where('fotos.homenageado_id',$id)->where('fotos.foto_perfil',true)->get()[0];
    }

    public function fotos()
    {
        return $this->hasMany('App\Models\Foto');
    }

    public function mensagens()
    {
        return $this->hasMany('App\Models\Mensagem');
    }

    public function curadores(){
        return $this->belongsToMany(User::class, 'curadores');
    }
}
