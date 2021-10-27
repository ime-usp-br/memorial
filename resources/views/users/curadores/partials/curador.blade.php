<strong>{{ $curador->name }}</strong>
@if(Auth::user()->id != $curador->id)
<a class="btn btn-outline-dark" href="/admin/removercurador/{{$curador->id}}/{{$homenageado->id}}" onclick="return confirm('Tem certeza?');">Remover</a>
@endif