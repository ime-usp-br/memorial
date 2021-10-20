@extends('main')

@section('content')
<div class="container-fluid">

  @include('homenageados.partials.homenageado') <br>

  @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#edit_homenageado">Editar homenageado</button>

    <div class="modal fade" id="edit_homenageado" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title">Editar homenageado</h4>
          </div>

          <div class="modal-body">
            <form action="/homenageados/{{$homenageado->id}}"  enctype="multipart/form-data" method="POST">
              @csrf
              @method('patch')
              @include('homenageados.partials.form')
            </form>
            <br>
            <form action="/homenageados/{{ $homenageado->id }} " method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar homenageado</button> 
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif

  <br>

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

          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mensagem">Deixar uma mensagem</button> <br>

          <div class="modal fade" id="mensagem" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title">Deixar uma mensagem</h4>
              </div>

              <?php
                $mensagem = new App\Models\Mensagem();
                $homenageado_id = $homenageado->id;
                $edit = false;
              ?>

              <div class="modal-body">
                <form action="/mensagems" method="POST">
                  @csrf
                  @include('mensagens.partials.forms')
                </form>
              </div>
            </div>

          </div>
          </div>

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
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#foto">Adicionar fotos</button>

            <div class="modal fade" id="foto" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Adicionar foto</h4>
                  </div>

                  <div class="modal-body">
                    <form action="/fotos" enctype="multipart/form-data" method="POST">
                      @csrf
                      <?php 
                        $homenageado_id = $homenageado->id;
                        $foto = new App\Models\Foto();
                      ?>
                      
                      @include('fotos.partials.forms')
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>
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

  
  
 

  @can('administrador')

  @if($homenageado->curadores->isNotEmpty())
    Esse homenageado é curado por: <br>
    @foreach($homenageado->curadores as $curador)
      {{$curador->name}} <br>
    @endforeach
  @endif
  <br>
  
  <div class="row justify-content-start">
    <div class="col-2">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCurador">Adicionar curador</button>

      <div class="modal fade" id="addCurador" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Adicionar curador</h4>
            </div>

            <div class="modal-body">
              <form action="/admin/novocurador" method="post">
                @csrf
                Número USP: <input type="text" name="codpes"> <br>
                <input type="hidden" name="homenageado_id" value="{{$homenageado->id}}">
                <button class="btn btn-success" type="submit">Enviar</button>
              </form>
            </div>

          </div>
        </div>
      </div>

    </div>
    <div class="col-2"> 
      <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeCurador">Remover curador</button> <br>

      <div class="modal fade" id="removeCurador" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Remover curador</h4>
            </div>

            <div class="modal-body">

              <?php 
                $curadores = $homenageado->curadores;
              ?>
              <form action="/admin/removercurador" method="post">
                @csrf
                <select name="curador">
                    <option value="" selected=""> - Selecione  -</option>
                    @foreach ($curadores as $curador)
                        <option value="{{$curador->codpes}}">
                            {{$curador->codpes}}
                        </option> 
                    @endforeach
                </select>

                <input type="hidden" name="homenageado_id" value="{{$homenageado->id}}"> <br><br>
                
                <button class="btn btn-danger" type="submit">Remover</button>
              </form>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div> 
  @endcan

</div>
@endsection









