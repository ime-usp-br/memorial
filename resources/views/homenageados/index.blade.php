@extends('main')

@section('content')


    <div class="container">


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


        



        <form method="GET" action="/homenageados">
            <div class="row">
                <div class="col-2 offset-10">
                    <div class=" col-sm input-group">
                        <input type="text" class="form-control" name="search" value="{{ request()->search }}">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success"> Buscar </button>
                        </span>

                    </div>
                </div>
            </div>
        </form>




        @foreach ($homenageados as $homenageado)
            @include('homenageados.partials.fields') <br><br>
        @endforeach
        {{ $homenageados->appends(request()->query())->links() }}
    </div>



@endsection
