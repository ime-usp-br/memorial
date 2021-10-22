<form>
    <div class="form-group">
        <label for="foto">Foto</label>
        <input class="form-control" id="foto" type="file" name="foto">
    </div>
    <br>
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <input type="text" id="descricao" class="form-control" name="descricao" value="{{old('desc', $foto->descricao)}}">
    </div>
    <br>
    <input type="hidden" name="homenageado_id" value="{{ $homenageado_id }}">
    <button class="btn btn-success" type="submit"> Enviar </button>
</form>
