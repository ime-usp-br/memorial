HOMENAGEADOS SOB RESPONSABILIDADE DO CURADOR {{$curador->nome}} - {{$curador->codpes}}: <br>

@foreach($curador->homenageados as $homenageado)
    @include('homenageados.partials.fields') <br><br>
@endforeach