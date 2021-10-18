<p style="padding: 10px 50px">
    <strong><a style="text-decoration:none" href="/homenageados/{{$homenageado->id}}">{{ $homenageado->nome }} (★{{(new Datetime($homenageado->data_nascimento))->format('Y')}} - ✞ {{(new Datetime($homenageado->data_falecimento))->format('Y')}})</a></strong>
    <br><small>{{$homenageado->funcao}}</small>
</p>






