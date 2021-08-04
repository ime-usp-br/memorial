HOMENAGEADOS SOB SUA RESPONSABILIDADE:

@foreach($user->homenageados as $homenageado)
    @include(homenageados.partials.fields) <br><br>
@endforeach