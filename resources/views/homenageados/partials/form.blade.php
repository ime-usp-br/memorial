<form>
    <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control" id="nome" type="text" name="nome" value="{{old('nome', $homenageado->nome)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="data_nascimento">Data de nascimento</label>
        <input class="form-control" id="data_nascimento" type="text" name="data_nascimento" value="{{old('data_nascimento', $data_nascimento)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="data_falecimento">Data de falecimento</label>
        <input class="form-control" id="data_falecimento" type="text" name="data_falecimento" value="{{old('data_falecimento', $data_falecimento)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="funcao">Função no instituto</label>
        <input id="funcao" class="form-control" type="text" name="funcao" value="{{old('funcao', $homenageado->funcao)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="biografia">Biografia</label>
        <textarea class="form-control" name="biografia" id="biografia" cols="30" rows="10">{{old('biografia', $homenageado->biografia)}}</textarea>
    </div>
    <br>
    <div class="form-group">
        <label for="foto_perfil">Foto de perfil</label>
        <input id="foto_perfil" class="form-control" type="file" name="foto_perfil">
    </div>
    <br>
    <div class="btn-group">
        <button type="submit" class="btn btn-outline-dark">Salvar</button>
        @if($edit)
        <a href="/homenageados/delete/{{ $homenageado->id }}" class="btn btn-outline-dark" onclick="return confirm('Tem certeza?');">Apagar</a> 
        @endif
    </div>

</form>
