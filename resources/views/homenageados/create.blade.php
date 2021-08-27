@extends('main')
@section('content')
<form action="/homenageados"  enctype="multipart/form-data" method="POST">
    @csrf
    @include('homenageados.partials.form')
</form>
@endsection

