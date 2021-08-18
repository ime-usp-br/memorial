@extends('main')

@include('homenageados.partials.homenageado') <br><br>

@if($homenageado->curadores->isNotEmpty())
  Esse homenageado é curado por: <br>
  @foreach($homenageado->curadores as $curador)
    {{$curador->name}} <br>
  @endforeach
@endif

<a href="/">Voltar</a> <br>

@if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
<a href="/homenageados/{{$homenageado->id}}/edit" class="btn btn-primary">Editar</a> <br>
@endif

@can('administrador')
  <form action="/homenageados/{{ $homenageado->id }} " method="POST">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar</button> 
  </form>

  <a href="{{'/admin/novocurador/'.$homenageado->id}}">Adicionar curador</a> <br>

  <a href="{{'/admin/removercurador/'.$homenageado->id}}">Remover curador</a> <br>
@endcan



<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="mensagens-tab" data-bs-toggle="tab" data-bs-target="#mensagens" type="button" role="tab" aria-controls="mensagens" aria-selected="true">Mensagens</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="fotos-tab" data-bs-toggle="tab" data-bs-target="#fotos" type="button" role="tab" aria-controls="fotos" aria-selected="false">Fotos</button>  
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="mensagens" role="tabpanel" aria-labelledby="mensagens-tab">
    <a href="{{'/mensagems/create/'.$homenageado->id}}">Adicionar mensagens</a> <br>
    
    @foreach($homenageado->mensagens as $mensagem)
      @if($mensagem->estado == 'APROVADO' || ($mensagem->estado != 'APROVADO' && (Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))))
        @include('mensagens.partials.fields') 
      @endif
    @endforeach
    <br>
  </div>
  <div class="tab-pane" id="fotos" role="tabpanel" aria-labelledby="fotos-tab">
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
  </div>
</div>







