
<div class="card">
      <div class="card-body">
            <h5 class="card-title">{{$mensagem->nome}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$mensagem->instituicao}}</h6>
            <p class="card-text" style="font-size: 20px;">{{$mensagem->mensagem}}</p>
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
            <div class="row">
                  <div class="col">
                        <a href="/mensagems/{{$mensagem->id}}/edit" class="btn btn-primary">Editar</a>
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






