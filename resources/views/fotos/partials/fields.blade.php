
<div class="figure">
  <img src="/fotos/{{$foto->id}}" style="width: 350px; height: 350px; object-fit: cover;">
  <figcaption class="figure-caption text-center">{{$foto->descricao}}</figcaption>
  @if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
    <div class="row">
      <div class="col">
        <a href="/fotos/{{$foto->id}}/edit" class="btn btn-primary">Mudar foto</a>
      </div>
      <div class="col">
        <form action="/fotos/{{ $foto->id }} " method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Apagar</button> 
        </form>
      </div>
    </div>
  @endif
</div>