@extends('main')

@section('content')


    <div id="content">
        @if(Auth::user() == null)




       
        @endif

        


        @can('administrador')
            <div class="row justify-content-center">
                <div class="col-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#admin">Adicionar administrador</button>

                    <div class="modal fade" id="admin" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Adicionar administrador</h4>
                                </div>

                                <div class="modal-body">
                                    @include('users.novoadmin')
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHomenageado">Adicionar homenageado</button>

                    <div class="modal fade" id="addHomenageado" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Adicionar homenageado</h4>
                                </div>
                                
                                <?php 
                                    $homenageado = new App\Models\Homenageado();
                                ?>
                                <div class="modal-body">
                                    @include('homenageados.create')
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endcan


        



        <form method="GET" action="/homenageados">
            <div class="row">
                <div class="col-2 offset-10">
                    <div class=" col-sm input-group">
                        <input type="text" class="form-control" name="search" value="{{ request()->search }}">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-outline-dark"> Buscar </button>
                        </span>

                    </div>
                </div>
            </div>
        </form>




        @foreach ($homenageados as $homenageado)
            @include('homenageados.partials.fields')
        @endforeach
        {{ $homenageados->appends(request()->query())->links() }}
    </div>



@endsection
