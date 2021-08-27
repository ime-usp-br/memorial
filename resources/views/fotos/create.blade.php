@extends('main')
@section('content')
<form action="/fotos" enctype="multipart/form-data" method="POST">
    @csrf
    @include('fotos.partials.forms')
</form>
@endsection

