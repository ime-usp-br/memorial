<a href="/homenageados/{{$homenageado->id}}">{{ $homenageado->nome }} ({{(new Datetime($homenageado->data_nascimento))->format('d/m/Y')}} - {{(new Datetime($homenageado->data_falecimento))->format('d/m/Y')}})</a>

