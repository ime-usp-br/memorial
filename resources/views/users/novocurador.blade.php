<form action="/admin/novocurador" method="post">
    @csrf
    <form>
        <div class="form-group">
            <label for="add_curador">Número USP:</label>
            <input class="form-control" type="text" id="add_curador" name="codpes">
        </div>
        <br>
        <input type="hidden" name="homenageado_id" value="{{$homenageado_id}}">
        <button class="btn btn-outline-dark" type="submit">Salvar</button>
    </form>
</form>

