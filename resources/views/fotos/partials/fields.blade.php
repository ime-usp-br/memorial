
<div class="figure">
  <img src="/fotos/{{$foto->id}}" style="width: 350px; height: 350px; object-fit: contain;">
  <figcaption class="figure-caption text-center">{{$foto->descricao}}</figcaption>
  @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
    <div class="row">
      <div class="col">
        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#foto-desc-{{$foto->id}}">Editar descriçao</button>
        <div class="modal fade" id="foto-desc-{{$foto->id}}" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
              </div>


              <div class="modal-body">
                @include('fotos.partials.descricao')
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#foto-{{$foto->id}}">Substituir</button>
        <div class="modal fade" id="foto-{{$foto->id}}" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
              </div>

              <?php
                    $homenageado_id = $foto->homenageado_id;
                    $edit = true;
              ?>

              <div class="modal-body">
                @include('fotos.edit')
              </div>
              
            </div>
          </div>
        </div>

        

      </div>
      <div class="col">
        <form action="/fotos/{{ $foto->id }} " method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-dark" onclick="return confirm('Tem certeza?');">Excluir</button> 
        </form>
      </div>
    </div>
  @endif
</div>