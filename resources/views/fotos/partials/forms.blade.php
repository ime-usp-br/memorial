<form>
    <div class="form-group">
        <label for="foto">Foto</label>
        @if($edit)
            <input class="form-control" id="fotos" type="file" name="fotos[]">
        @else
            <input class="form-control" id="fotos" type="file" name="fotos[]" multiple>
        @endif
    </div>
    <br>
    <input type="hidden" name="homenageado_id" value="{{ $homenageado_id }}">
    <button class="btn btn-outline-dark" type="submit"> Salvar </button>
</form>
