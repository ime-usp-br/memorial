<input type="hidden" name="homenageado_id" value="{{ $homenageado_id }}">
<input type="file" name="foto">
<input type="text" name="desc" value="{{old('desc', $foto->descricao)}}">

<button type="submit"> Enviar </button>
