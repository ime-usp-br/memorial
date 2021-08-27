@extends('main')
@section('content')
<form action="/fotos/{{$foto->id}}" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PATCH')
    @include('fotos.partials.forms')
</form>
@endsection

