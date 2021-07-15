@include('homenageados.partials.fields') <br>

@if(Auth::user() != null)
    <a href="/homenageados/{{$homenageado->id}}/edit">Editar</a> <br>
    <form action="/homenageados/{{ $homenageado->id }} " method="POST">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
@endif

<a href="/">Voltar</a>