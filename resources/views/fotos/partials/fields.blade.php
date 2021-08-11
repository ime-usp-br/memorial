<img width="300px" src="/fotos/{{$foto->id}}"> <br>
{{$foto->descricao}} <br>

@if(Gate::allows('administrador') || Gate::allows('curador', [$foto->homenageado_id]))
  <a href="/fotos/{{$foto->id}}/edit">Alterar foto</a> <br>
  <form action="/fotos/{{ $foto->id }} " method="POST">
    @csrf
    @method('delete')
    <button type="submit" onclick="return confirm('Tem certeza?');">Apagar foto</button> 
  </form>
@endif
