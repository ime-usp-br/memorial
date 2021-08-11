Nome: <input type="text" name="nome" value="{{old('nome', $homenageado->nome)}}"> <br>
Data de nascimento: <input type="text" name="data_nascimento" value="{{old('data_nascimento', (new Datetime($homenageado->data_nascimento))->format('d/m/Y'))}}"> <br>
Data de falecimento: <input type="text" name="data_falecimento" value="{{old('data_falecimento', (new Datetime($homenageado->data_falecimento))->format('d/m/Y'))}}"> <br>
Biografia: <input type="text" name="biografia" value="{{old('biografia', $homenageado->biografia)}}"> <br>
Foto: <input type="file" name="foto_perfil"> <br>

<button type="submit">Enviar</button>