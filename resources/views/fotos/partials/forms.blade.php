


<form action="/fotos" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="homenageado_id" value="{{ $homenageado->id }}">
    <input type="file" name="foto">
    <input type="text" name="desc">

    <button type="submit"> Enviar </button>
</form>