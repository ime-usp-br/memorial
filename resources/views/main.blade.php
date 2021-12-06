<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorial</title>
    <link rel="stylesheet" href="{{ asset('site/style.css') }}">
    <link rel="stylesheet" href="{{ asset('site/landingpage.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400&display=swap" 
    rel="stylesheet">
    <link href="{{ captcha_layout_stylesheet_url() }}" type="text/css" rel="stylesheet">
</head>

<body>
    <div id="app">

        <div id="content">
            <div class="container-fluid mainimg">


                <div class="container maintxt">
                    <div class="row">
                        <div class="col-8">
                            <h1 class="title"> <a href="/" class="nav-link text-white">Memorial do IME-USP</a></h1>

                            
                                <p>
                                    <strong>“Dê-me uma alavanca e um ponto de apoio e levantarei o mundo”</strong>
                                    <br><em>Arquimedes</em>
                                </p>
                                <p>Assim é a obra de nossos professores, funcionários, alunos e ex-alunos. Cada nome
                                    homenageado neste site
                                    representa alguém que faz muita falta e é
                                    lembrado com carinho por colegas, familiares e entes queridos. O imensurável legado
                                    daqueles que marcaram a
                                    história do Instituto continua a nos inspirar todos os dias.</p>
                            

                        </div>

                        <div class="col-2 offset-2">

                            @if (Auth::user() == null)
                                <a class="nav-link text-white" href="/login"><i class="cil-account-logout"></i>
                                    Login</a>
                            @else
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link text-white"><i
                                            class="cil-account-logout"></i> Logout</button>
                                </form>


                                <a href="/admin" class="btn btn-link text-white text-decoration-none"><i class="cil-group"></i> Administradores</a>

                                <button class="btn btn-link text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#addHomenageado"><i class="cil-user-plus"></i> Homenageados</button>


                                
                            @endif



                        </div>
                    </div>

                </div>




            </div>



            <div class="container" style="margin-bottom: 100px; margin-top: 30px">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if (Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-bs-dismiss="alert" aria-label="fechar">&times;</a>
                            </p>
                        @endif
                    @endforeach
                </div>

                @yield('content')

                <div class="modal fade" id="addHomenageado" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">Adicionar homenageado</h4>
                                <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
                            </div>
                            
                            <?php 
                                $homenageado = new App\Models\Homenageado();
                                $edit = false;
                                $data_nascimento = null;
                                $data_falecimento = null;
                            ?>
                            <div class="modal-body">
                                @include('homenageados.create')
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>



        <footer id="footer" class="bg-footer">

            <div class="container">

                <div class="row p-3">
                    <div class="col-12">
                        <p class="text-center"><strong class="titlefooter">Memorial do <a href="https://www.ime.usp.br" class="text-white" style="text-decoration:none">IME-USP</a></strong> 
                            <br><small>Um pequeno gesto para homenagear aqueles que contribuíram com o Instituto</small></p>
                    </div>
                </div>
              
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
                integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"
                async></script>
        <script src="{{ asset('site/jquery.js') }}"></script>
        <script src="{{ asset('site/bootstrap.js') }}"></script>
    </div>

</body>

</html>
