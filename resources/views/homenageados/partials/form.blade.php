Nome: <input type="text" name="nome" value="{{old('nome', $homenageado->nome)}}"> <br>
Data de nascimento: <input type="date" name="data_nasc" value="{{old('data_nasc', $homenageado->data_nascimento)}}"> <br>
Data de falecimento: <input type="date" name="data_fale" value="{{old('data_fale', $homenageado->data_falecimento)}}"> <br>
Biografia: <input type="text" name="bio" value="{{old('bio', $homenageado->biografia)}}"> <br>
Foto: <input type="file" name="foto"> <br>

<button type="submit">Enviar</button>