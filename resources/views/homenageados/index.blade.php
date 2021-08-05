@extends('main')
@if(Auth::user() == null)
    <a href="/login">Login</a> <br>
@else
    <form action="/logout" method="POST">
        @csrf
        <button type="submit">logout</button>
    </form> 

    <a href="admin/novoadmin">Adicionar administrador</a> <br>

    <a href="/homenageados/create">Adicionar homenageado</a> <br>


@endif

<br>

@foreach($homenageados as $homenageado)
    @include('homenageados.partials.fields') <br><br>
@endforeach


