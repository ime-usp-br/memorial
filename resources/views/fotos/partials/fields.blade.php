<img width="300px" src="/fotos/{{$foto->id}}"> <br>
{{$foto->descricao}} <br>

<a href="/fotos/{{$foto->id}}/edit">Editar foto</a> <br>
<form action="/fotos/{{ $foto->id }} " method="POST">
  @csrf
  @method('delete')
  <button type="submit" onclick="return confirm('Tem certeza?');">Apagar foto</button> 
</form>
