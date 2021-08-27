<a href="/homenageados/{{$homenageado->id}}">{{ $homenageado->nome }} ({{(new Datetime($homenageado->data_nascimento))->format('Y')}} - <i class="cil-cross"></i>{{(new Datetime($homenageado->data_falecimento))->format('Y')}})</a>

