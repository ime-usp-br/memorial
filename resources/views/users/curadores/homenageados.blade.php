HOMENAGEADOS SOB RESPONSABILIDADE DO CURADOR {{$curador->nome}} - {{$curador->codpes}}: <br><br>

@foreach($curador->homenageados as $homenageado)
    @include('homenageados.partials.fields') <br><br>
@endforeach

<a href="/">Voltar ao início</a>