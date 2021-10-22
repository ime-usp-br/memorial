<form action="/admin/novoadmin" method="post">
    @csrf
    <form>
        <div class="form-group">
            <label for="codpes">Número USP</label>
            <input id="codpes" class="form-control" type="text" name="codpes">
        </div>
        <br>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</form>

