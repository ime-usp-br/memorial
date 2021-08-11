@extends('main')
@include('homenageados.partials.homenageado') <br><br>

<a href="{{'/mensagems/create/'.$homenageado->id}}">Adicionar mensagens</a> <br>


MENSAGENS: <br>
@foreach($homenageado->mensagens as $mensagem)
  @if($mensagem->estado == 'APROVADO' || ($mensagem->estado != 'APROVADO' && (Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))))
    @include('mensagens.partials.fields') <br>
  @endif
@endforeach
<br>


@if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
  <a href="{{'/fotos/create/'.$homenageado->id}}">Adicionar fotos</a>
  <br>
@endif


FOTOS: <br>
@foreach($homenageado->fotos as $foto)
  @if(!$foto->foto_perfil)
    @include('fotos.partials.fields') <br>
  @endif
@endforeach

<br>

@if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
<a href="/homenageados/{{$homenageado->id}}/edit">Editar</a> <br>
@endif

@can('administrador')
  <form action="/homenageados/{{ $homenageado->id }} " method="POST">
    @csrf
    @method('delete')
    <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
  </form>

  <a href="{{'/admin/novocurador/'.$homenageado->id}}">Adicionar curador</a> <br>

  <a href="{{'/admin/removercurador/'.$homenageado->id}}">Remover curador</a> <br>
@endcan


<a href="/">Voltar</a>