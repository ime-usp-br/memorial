<strong>{{ $curador->name }}</strong>
@if(Auth::user()->id != $curador->id)
[ <a class="link-dark text-decoration-none" href="/admin/removercurador/{{$curador->id}}/{{$homenageado->id}}" onclick="return confirm('Tem certeza?');">remover</a> ]
@endif