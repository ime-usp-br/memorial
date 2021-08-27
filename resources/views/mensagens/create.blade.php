@extends('main')
@section('content')
<form action="/mensagems" method="POST">
    @csrf
    @include('mensagens.partials.forms')
</form>
@endsection


