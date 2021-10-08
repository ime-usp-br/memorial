@extends('main')
@section('content')
<br>
<form action="/admin/novocurador" method="post">
    @csrf
    Número USP: <input type="text" name="codpes"> <br>
    <input type="hidden" name="homenageado_id" value="{{$homenageado_id}}">
    <button type="submit">Enviar</button>
</form>
@endsection
