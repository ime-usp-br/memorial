@extends('main')

@section('content')
    

    <div class="container" style="margin-top: 20px;">


        @can('administrador')
        <br>
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
        <form method="GET" action="/homenageados">
        <div class="row">
            <div class=" col-sm input-group">
            <input type="text" class="form-control" name="search" value="{{ request()->search }}">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-success"> Buscar </button>
            </span>

            </div>
        </div>
        </form>
        
        <p>Lamentamos profundamente a perda de nossos professores, funcionários, alunos, ex-alunos e aposentados. Cada nome homenageado neste site 
            representa alguém que faz muita falta e é lembrado com carinho por colegas, familiares e entes queridos. 
            Este é apenas um pequeno gesto para homenagear aqueles que contribuíram com o IME-USP.


        <br>
        
        @foreach($homenageados as $homenageado)
            @include('homenageados.partials.fields') <br><br>
        @endforeach
        {{ $homenageados->appends(request()->query())->links() }}
    </div>
    


@endsection







