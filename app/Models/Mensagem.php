<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function homenageado(){
        return $this->belongsTo('App\Models\Homenageado');
    }

    public function tokens(){
        return $this->belongsToMany(User::class, 'tokens')->withPivot(['token', 'expires_in']);
    }


    public function estados(){
        return [
            'PENDENTE',
            'APROVADO',
            'NEGADO'
        ];
    }

    public function tipos_aprovacao(){
        return [
            'EDIÇÃO',
            'TOKEN',
            'CRIADA POR RESPONSÁVEL'
        ];
    }
}
