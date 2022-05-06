<form action="/fotos/descricao" method="POST">
    @csrf
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <input class="form-control" type="text" name="descricao" id="descricao" value="{{old('descricao', $foto->descricao)}}">
        <input type="hidden" name="foto_id" value="{{ $foto->id }}">
        <br>
        <button class="btn btn-outline-dark" type="submit"> Salvar </button>
    </div>
</form>