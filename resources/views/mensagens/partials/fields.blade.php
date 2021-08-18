
<div class="card" style="width: 18rem;">
      <div class="card-body">
            <h5 class="card-title">{{$mensagem->nome}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$mensagem->instituicao}}</h6>
            <p class="card-text">{{$mensagem->mensagem}}</p>
            @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
            <a href="/mensagems/{{$mensagem->id}}/edit" class="btn btn-primary">Editar</a>
            <form action="/mensagems/{{ $mensagem->id }} " method="post">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar</button> 
            </form>
            @endif
      </div>
</div>






