@extends('main')
@section('content')
<form action="/homenageados/{{$homenageado->id}}"  enctype="multipart/form-data" method="POST">
    @csrf
    @method('patch')
    @include('homenageados.partials.form')
</form>
@endsection
