<div class="card">
      <div class="card-body">
            <h5 class="card-title">{{$mensagem->nome}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$mensagem->instituicao}}</h6>
            <p class="card-text" style="font-size: 20px;">{{$mensagem->mensagem}}</p>
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
            <div class="row">
                  <div class="col">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-{{$mensagem->id}}">Editar</button>

                        <div class="modal fade" id="edit-{{$mensagem->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                              <div class="modal-content">

                              <div class="modal-header">
                              <h4 class="modal-title">Editar mensagem</h4>
                              </div>

                              <?php
                              $homenageado_id = $homenageado->id;
                              $edit = true;
                              ?>

                              
                              <div class="modal-body">
                                    <form action="/mensagems/{{$mensagem->id}}" method="POST">
                                    @csrf
                                    @method('patch')
                                    @include('mensagens.partials.forms')
                                    </form>
                              </div>
                              

                              </div>

                        </div>
                        </div>
                  </div>
                  <div class="col">
                        <form action="/mensagems/{{ $mensagem->id }} " method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar</button> 
                        </form>
                  </div>
            </div>
            @endif
      </div>
</div>






