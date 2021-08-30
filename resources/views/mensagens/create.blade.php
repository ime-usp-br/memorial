@extends('main')
@section('content')
<br>
<form action="/mensagems" method="POST">
    @csrf
    @include('mensagens.partials.forms')
</form>
@endsection


