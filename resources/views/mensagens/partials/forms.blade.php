Nome: <input type="text" name="nome" value="{{old('nome', $mensagem->nome)}}"> <br>
Email: <input type="email" name="email" value="{{old('email', $mensagem->email)}}"> <br>
Instituição: <input type="text" name="instituicao" value="{{old('instituicao', $mensagem->instituicao)}}"> <br>
<input type="hidden" name="homenageado_id" value="{{$homenageado_id}}">
Mensagem: <br>
<textarea name="mensagem" cols="30" rows="10"></textarea> <br>
<button type="submit">Enviar</button> <br>
