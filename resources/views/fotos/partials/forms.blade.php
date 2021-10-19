<input type="hidden" name="homenageado_id" value="{{ $homenageado_id }}">
Foto: <input type="file" name="foto"> <br><br>
Descrição: <input type="text" name="descricao" value="{{old('desc', $foto->descricao)}}"> <br><br>

<button class="btn btn-success" type="submit"> Enviar </button>
