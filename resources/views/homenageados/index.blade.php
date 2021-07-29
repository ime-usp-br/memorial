@extends('main')
@if(Auth::user() == null)
    <a href="/login">Login</a> <br>
@else
    <a href="/homenageados/create">Adicionar homenageado</a>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit">logout</button>
    </form>
@endif

@foreach($homenageados as $homenageado)
    @include('homenageados.partials.fields') <br><br>
@endforeach


