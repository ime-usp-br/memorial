@include('homenageados.partials.homenageado') <br>

@if(Auth::user() != null)
  <a href="{{'/fotos/create/'.$homenageado->id}}">Adicionar fotos</a>
  <br><br>
@endif


@foreach($homenageado->fotos as $foto)
  @if(!$foto->foto_perfil)
    @include('fotos.partials.fields') <br>
  @endif
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