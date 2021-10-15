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
</head>

<body>
    <div id="app">
        <div id="content">
            <div class="container-fluid" style="background-color: #e6e6fa; padding: 10px;">
            <div class="container">
                <div class="row p-3">
                    <div class="col-10">
                        <a href="/">
                            <img src="{{ asset('img/logoIme.png') }}">
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="https://www.usp.br">
                            <img src="{{ asset('img/logoUsp.png') }}" style="float: right;">
                        </a>
                    </div>
                </div>
            </div>
        </div>

            <div class="container-fluid" style="background-color: #e6e6fa; padding: 10px;">
                <div class="container">
                    <h4 style="color: #4b0082" class="text-center">Memorial do IME-USP</h4>
                    <p style="color: #4b0082" class="text-center">Este site é apenas um pequeno gesto para homenagear aqueles que contribuíram com o IME-USP</p>

                    <br>
                    
                  
                </div>
            </div>

            <div class="container-fluid" style="background-color: #ffffff; padding: 50px;">
                <div class="container">

                    <p style="color: #4b0082; padding: 50px 100px;"> <strong>“Dê-me uma alavanca e um ponto de apoio e levantarei o mundo”</strong>
                        <br><em>Arquimedes</em>
                    </p>
                    <p style="color: #4b0082; padding: 0px 100px;" class="justify-text">Assim é a obra de nossos professores, funcionários, alunos e ex-alunos. Cada nome homenageado neste site
                        representa alguém que faz muita falta e é
                        lembrado com carinho por colegas, familiares e entes queridos. O imensurável legado daqueles que marcaram a
                        história do Instituto continua a nos inspirar todos os dias.</p>
                                     
                </div>
            </div>



            <div class="container">
                @yield('content')
            </div>
        </div>



        <footer id="footer" style="background-color: #142C68; padding: 10px;">
            <div class="container">


                <div class="row p-3">
                    <div class="col-10">
                        <span class="nav-link text-white"><strong>Memorial</strong></span>
                        <a href="https://www.ime.usp.br" class="nav-link text-white">Instituto de Matemática e
                            Estatística</a>
                        <a href="https://www.usp.br" class="nav-link text-white">Universidade de São Paulo</a>
                    </div>

                    <div class="col-2">

                        @if (Auth::user() == null)
                            <a class="nav-link text-white" href="/login"><i class="cil-account-logout"></i>
                                Login</a>
                        @else
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="nav-link text-white btn btn-link"><i
                                        class="cil-account-logout"></i> Logout</button>
                            </form>
                        @endif

                    </div>


                </div>
            </div>
        </footer>




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
                        <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a>
                    </p>
                @endif
            @endforeach
        </div>

        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
                integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"
                async></script>
        <script src="{{ asset('site/jquery.js') }}"></script>
        <script src="{{ asset('site/bootstrap.js') }}"></script>
    </div>

</body>

</html>
