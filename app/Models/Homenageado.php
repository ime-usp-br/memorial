<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Homenageado extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function formatData($homenageado){
        $homenageado->data_nascimento = Carbon::parse($homenageado->data_nascimento)->format('d/m/Y');
        $homenageado->data_falecimento = Carbon::parse($homenageado->data_falecimento)->format('d/m/Y');
        return $homenageado;
    }
}
