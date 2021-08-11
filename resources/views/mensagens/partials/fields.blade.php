Nome: {{$mensagem->nome}} <br>
Instituição: {{$mensagem->instituicao}} <br>
Mensagem: {{$mensagem->mensagem}}<br>


@if(Gate::allows('administrador') || Gate::allows('curador', [$mensagem->homenageado_id]))
<a href="/mensagems/{{$mensagem->id}}/edit">Editar mensagem</a> <br>
<form action="/mensagems/{{ $mensagem->id }} " method="post">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
</form>
@endif
<br>






