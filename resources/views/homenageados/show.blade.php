@extends('main')

@section('content')
<div class="container-fluid" style="margin-top: 20px; margin-bottom: 20px;">

  @include('homenageados.partials.homenageado') <br>

  @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
  <div class="row">
    <div class="col-3">
      <a href="/homenageados/{{$homenageado->id}}/edit" class="btn btn-primary">Editar homenageado</a>
    </div>
    <div class="col-3"> 
      <form action="/homenageados/{{ $homenageado->id }} " method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar homenageado</button> 
      </form>
    </div>
  </div>
  @endif

  <br>

  <a href="/" class="btn btn-warning">Voltar para página inicial</a> <br><br>

  <br>

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="mensagens-tab" data-bs-toggle="tab" data-bs-target="#mensagens" type="button" role="tab" aria-controls="mensagens" aria-selected="true">Mensagens</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="fotos-tab" data-bs-toggle="tab" data-bs-target="#fotos" type="button" role="tab" aria-controls="fotos" aria-selected="false">Fotos</button>  
    </li>
  </ul>

  <div class="container-fluid">
    <div class="tab-content">
      <div class="tab-pane active" id="mensagens" role="tabpanel" aria-labelledby="mensagens-tab">
        <div class="container-fluid" style="margin-top: 10px;  margin-bottom: 10px;">
          <a href="{{'/mensagems/create/'.$homenageado->id}}" class="btn btn-success">Adicionar mensagens</a> <br>
          <div class="card-columns" style="margin-top: 10px;">
            @foreach($homenageado->mensagens as $mensagem)
              @if($mensagem->estado == 'APROVADO' || ($mensagem->estado != 'APROVADO' && (Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))))
                @include('mensagens.partials.fields') 
              @endif
            @endforeach
            <br>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="fotos" role="tabpanel" aria-labelledby="fotos-tab">
        <div class="container-fluid" style="margin-top: 10px;">
          @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
            <a href="{{'/fotos/create/'.$homenageado->id}}" class="btn btn-success">Adicionar fotos</a>
            <br>
          @endif
          @foreach(array_chunk($fotos, 3) as $fotos)
            <div class="row" style="margin-top: 10px;">
              @foreach($fotos as $foto)
                @if(!$foto->foto_perfil)
                  <div class="col-sm-4 lg-2">
                    @include('fotos.partials.fields')
                  </div>
                @endif
              @endforeach
            </div>
            <br>
          @endforeach
          <br>
        </div>
        
      </div>
    </div>
  </div>

  @if($homenageado->curadores->isNotEmpty())
    Esse homenageado é curado por: <br>
    @foreach($homenageado->curadores as $curador)
      {{$curador->name}} <br>
    @endforeach
  @endif
  <br>

  @can('administrador')
  <div class="row justify-content-start">
    <div class="col-2">
    <a href="{{'/admin/novocurador/'.$homenageado->id}}" class="btn btn-primary">Adicionar curador</a>
    </div>
    <div class="col-2"> 
      <a href="{{'/admin/removercurador/'.$homenageado->id}}" class="btn btn-danger">Remover curador</a> <br>
    </div>
  </div> 
  @endcan

</div>
@endsection









