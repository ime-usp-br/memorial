@include('homenageados.partials.homenageado') <br>

@include('fotos.partials.forms')
<br><br>


@foreach($homenageado->fotos as $foto)
  <img src="/fotos/{{$foto->id}}"> <br>
  {{$foto->descricao}} <br>
@endforeach


@if(Auth::user() != null)
    <a href="/homenageados/{{$homenageado->id}}/edit">Editar</a> <br>
    <form action="/homenageados/{{ $homenageado->id }} " method="POST">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
@endif

<a href="/">Voltar</a>