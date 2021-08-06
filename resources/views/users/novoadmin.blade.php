@extends('main')
<form action="admin/novoadmin" method="post">
    @csrf
    Número USP: <input type="text" name="codpes"> <br>
    <button type="submit">Enviar</button>
</form>