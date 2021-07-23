Nome: {{$mensagem->nome}} <br>
Instituição: {{$mensagem->instituicao}} <br>
<textarea name="msg" cols="30" rows="10">{{$mensagem->mensagem}}</textarea> <br>
@if(Auth::user() != null)
      <a href="/mensagems/{{$mensagem->id}}/edit">Editar mensagem</a> <br>
      <form action="/mensagems/{{ $mensagem->id }} " method="post">
            @csrf
            @method('delete')
            <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
      </form>
      <br>
@endif





