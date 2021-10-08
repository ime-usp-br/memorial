<div class="card">
    <div class="card-body">
        <h5 class="card-title"><a href="/homenageados/{{$homenageado->id}}">{{ $homenageado->nome }} ({{(new Datetime($homenageado->data_nascimento))->format('Y')}} - {{(new Datetime($homenageado->data_falecimento))->format('Y')}})</a></h5>
        <h6 class="card-subtitle mb-2">{{$homenageado->funcao}}</h6>
    </div>
</div>





