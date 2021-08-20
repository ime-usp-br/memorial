Nome: <input type="text" name="nome" value="{{old('nome', $homenageado->nome)}}"> <br>
Data de nascimento: <input type="text" name="data_nascimento" value="{{old('data_nascimento', (new Datetime($homenageado->data_nascimento))->format('d/m/Y'))}}"> <br>
Data de falecimento: <input type="text" name="data_falecimento" value="{{old('data_falecimento', (new Datetime($homenageado->data_falecimento))->format('d/m/Y'))}}"> <br>
Biografia: <br> <textarea name="biografia" id="" cols="30" rows="10">{{old('biografia', $homenageado->biografia)}}</textarea> <br>
Foto de perfil: <input type="file" name="foto_perfil"> <br>

<button type="submit">Enviar</button>

