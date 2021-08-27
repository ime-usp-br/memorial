@extends('main')

@section('content')
    <div class="container" style="margin-top: 10dp;">
        @can('administrador')
        <div class="row justify-content-center">
            <div class="col-3">
                <a href="admin/novoadmin" class="btn btn-primary">Adicionar administrador</a>
            </div>
            <div class="col-3">
                <a href="/homenageados/create" class="btn btn-primary">Adicionar homenageado</a>
            </div>
        </div>
        @endcan
        

        <br>

        @foreach($homenageados as $homenageado)
            @include('homenageados.partials.fields') <br><br>
        @endforeach
    </div>
    


@endsection







