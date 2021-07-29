Nome: <input type="text" name="nome" value="{{old('nome', $homenageado->nome)}}"> <br>
Data de nascimento: <input type="date" name="data_nascimento" value="{{old('data_nascimento', $homenageado->data_nascimento)}}"> <br>
Data de falecimento: <input type="date" name="data_falecimento" value="{{old('data_falecimento', $homenageado->data_falecimento)}}"> <br>
Biografia: <input type="text" name="biografia" value="{{old('biografia', $homenageado->biografia)}}"> <br>
Foto: <input type="file" name="foto_perfil"> <br>

<button type="submit">Enviar</button>