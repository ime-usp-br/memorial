@extends('main')
@include('homenageados.partials.homenageado') <br><br>

<a href="{{'/mensagems/create/'.$homenageado->id}}">Adicionar mensagens</a> <br>


MENSAGENS: <br>
@foreach($homenageado->mensagens as $mensagem)
  @include('mensagens.partials.fields') <br>
@endforeach
<br>



<a href="{{'/fotos/create/'.$homenageado->id}}">Adicionar fotos</a>
<br>


FOTOS: <br>
@foreach($homenageado->fotos as $foto)
  @if(!$foto->foto_perfil)
    @include('fotos.partials.fields') <br>
  @endif
@endforeach

<br>



<a href="/homenageados/{{$homenageado->id}}/edit">Editar</a> <br>
<form action="/homenageados/{{ $homenageado->id }} " method="POST">
  @csrf
  @method('delete')
  <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
</form>

<a href="{{'/novocurador/'.$homenageado->id}}">Adicionar curador</a> <br>


<a href="/">Voltar</a>