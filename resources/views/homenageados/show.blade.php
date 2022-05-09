@extends('main')

@section('content')
<div class="container-fluid">
  @include('homenageados.partials.homenageado') <br>

  @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#edit_homenageado">Editar</button>

    <div class="modal fade" id="edit_homenageado" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
          </div>

          <?php 
            $edit = true;
            $data_nascimento = null;
            $data_falecimento = null;
            if($homenageado->data_nascimento) 
              $data_nascimento = (new Datetime($homenageado->data_nascimento))->format('d/m/Y');

            if($homenageado->data_falecimento) 
              $data_falecimento = (new Datetime($homenageado->data_falecimento))->format('d/m/Y');
          ?>


          <div class="modal-body">
            @include('homenageados.edit')
          </div>
        </div>
      </div>
    </div>
  @endif

  <br>

  <br>

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link @if($tabId ?? 'mensagem' == 'mensagem') active @endif" id="mensagens-tab" data-bs-toggle="tab" data-bs-target="#mensagens" type="button" role="tab" aria-controls="mensagens" aria-selected="true">Mensagens</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link {{ session()->get('tabId') === 'fotos' ? 'active' : '' }}'" id="fotos-tab" data-bs-toggle="tab" data-bs-target="#fotos" type="button" role="tab" aria-controls="fotos" aria-selected="false">Fotos</button>  
    </li>
    @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
    <li class="nav-item" role="presentation">
      <button class="nav-link @if($tabId ?? 'mensagem' == 'curadoria') active @endif" id="curadoria-tab" data-bs-toggle="tab" data-bs-target="#curadoria" type="button" role="tab" aria-controls="curadoria" aria-selected="false">Curadoria</button>
    </li>
    @endif
  </ul>

  <div class="container-fluid">
    <div class="tab-content">
      <div class="tab-pane @if($tabId ?? 'mensagem'=='mensagem') active @endif" id="mensagens" role="tabpanel" aria-labelledby="mensagens-tab">
        <div class="container-fluid" style="margin-top: 10px;  margin-bottom: 10px;">
  
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mensagem">Deixar uma mensagem</button> <br>

          <div class="modal fade" id="mensagem" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">


              <div class="modal-header">
              <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
              </div>


              <?php
                $mensagem = new App\Models\Mensagem();
                $homenageado_id = $homenageado->id;
                $edit = false;
              ?>



              <div class="modal-body">
                @include('mensagens.create')
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
      <div class="tab-pane {{ session()->get('tabId') === 'fotos' ? 'active' : '' }}'" id="fotos" role="tabpanel" aria-labelledby="fotos-tab">
        <div class="container-fluid" style="margin-top: 10px;">
          @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#foto">Adicionar fotos</button>

            <div class="modal fade" id="foto" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title">Adicionar foto</h4>
                    <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                  </div>

                  <?php 
                        $homenageado_id = $homenageado->id;
                        $foto = new App\Models\Foto();
                        $edit = false;
                  ?>

                  <div class="modal-body">
                    @include('fotos.create')
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

      @if(Gate::allows('administrador') || Gate::allows('curador', [$homenageado->id]))
      <div class="tab-pane @if($tabId ?? 'mensagem' == 'curadoria') active @endif" id="curadoria" role="tabpanel" aria-labelledby="curadoria-tab">
        <div class="container-fluid" style="margin-top: 10px;">
          <ul>
            @foreach($homenageado->curadores as $curador)
              <li>@include('users.curadores.partials.curador') </li>
            @endforeach
          </ul>

          <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addCurador">Adicionar curador</button>

          <div class="modal fade" id="addCurador" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  @include('users.novocurador')
                </div>

              </div>
            </div>
          </div>


    
        </div>
      </div>
      @endif
    </div>
  </div>

  
  
 

  @if(Auth::user() == null)
    @if($homenageado->curadores->isNotEmpty())
      <strong>Curadoria:</strong>  <br>
      @foreach($homenageado->curadores as $curador)
        {{$curador->name}} <br>
      @endforeach
    @endif
  @endif

</div>
@endsection









