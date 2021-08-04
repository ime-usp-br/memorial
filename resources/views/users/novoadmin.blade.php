@extends('main')
<form action="/novoadmin" method="post">
    @csrf
    Número USP: <input type="text" name="codpes"> <br>
    <button type="submit">Enviar</button>
</form>