<div class="card">
      <div class="card-body">
            <h5 class="card-title">{{$mensagem->nome}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$mensagem->instituicao}}</h6>
            <p class="card-text" style="font-size: 20px;">{{$mensagem->mensagem}}</p>
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#edit-{{$mensagem->id}}">Editar</button>

            <div class="modal fade" id="edit-{{$mensagem->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">

                  <div class="modal-header">
                  <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                  </div>
                 

                  <?php
                  $homenageado_id = $homenageado->id;
                  $edit = true;
                  ?>

                  
                  <div class="modal-body">

                        @include('mensagens.edit')
                        
                        <br>
                        <form action="/mensagems/{{ $mensagem->id }} " method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-dark" onclick="return confirm('Tem certeza?');">Apagar</button> 
                        </form>
                  </div>
                  

                  </div>

            </div>
            </div>
            @endif
      </div>
</div>






