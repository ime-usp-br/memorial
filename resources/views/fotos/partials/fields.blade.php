
<div class="card" style="width: 18rem;">
  <img alt="Card image cap" class="card-img-top embed-responsive-item" src="/fotos/{{$foto->id}}">
  <div class="card-body">
    <p class="card-text">{{$foto->descricao}}</p>
    @if(Gate::allows('administrador') || Gate::allows('curador', [$foto->homenageado_id]))
    <a href="/fotos/{{$foto->id}}/edit" class="btn btn-primary">Alterar foto</a>
    <form action="/fotos/{{ $foto->id }} " method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
    @endif
  </div>
</div>