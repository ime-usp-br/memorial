<div class="card">

      <div class="card-body">
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
                  @if($mensagem->estado == "APROVADO")
                  <div class="bulletpoint-aprovado" style="margin: 10px">
                        <ul>
                              <li></li>
                        </ul>
                  </div>
                  @elseif($mensagem->estado == "PENDENTE")
                  <div class="bulletpoint-pendente" style="margin: 10px">
                        <ul>
                              <li></li>
                        </ul>
                  </div>
                  @elseif($mensagem->estado == "NEGADO")
                  <div class="bulletpoint-negado" style="margin: 10px">
                        <ul>
                              <li></li>
                        </ul>
                  </div>
                  @endif
            @endif
            <p class="card-text">{{$mensagem->mensagem}}</p>
            <p class="text-muted"><i>{{$mensagem->nome}}</i> <br> {{$mensagem->instituicao}}</p>
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#edit-{{$mensagem->id}}">Editar</button>

            <div class="modal fade" id="edit-{{$mensagem->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">

                  <div class="modal-header">
                  <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                  </div>
                  

                  <?php
                  $homenageado_id = $mensagem->homenageado_id;
                  $edit = true;
                  ?>

                  
                  <div class="modal-body">

                        @include('mensagens.edit')
                        
                  </div>
                  

                  </div>

            </div>
            </div>
            @endif  
      </div>
</div>






