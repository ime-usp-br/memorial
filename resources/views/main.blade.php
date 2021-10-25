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
            <div class="container-fluid mainimg">
               
               
                <div class="container maintxt">
                    <div class="row">
                    <div class="col-6">
                        <h1 class="title">Memorial do IME-USP</h1>
                       
                         <div style="padding: 10% 30%;">
                             <p>
                            <strong>“Dê-me uma alavanca e um ponto de apoio e levantarei o mundo”</strong>
                            <br><em>Arquimedes</em>
                             </p>
                         </div>

                        <div style="margin: 0 0 50px 0">
                            <p>Assim é a obra de nossos professores, funcionários, alunos e ex-alunos. Cada nome homenageado neste site
                           representa alguém que faz muita falta e é
                           lembrado com carinho por colegas, familiares e entes queridos. O imensurável legado daqueles que marcaram a
                           história do Instituto continua a nos inspirar todos os dias.</p>
                        </div>
                    </div>

                <div class="col-2 offset-4">

                    @if (Auth::user() == null)
                        <a class="nav-link text-white" href="/login"><i class="cil-account-logout"></i>
                            Login</a>
                    @else
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white"><i
                                    class="cil-account-logout"></i> Logout</button>
                        </form>
                    @endif

                </div>
            </div>
                
                </div>	
            

            
        
    </div>



            <div class="container" style="margin-bottom: 100px; margin-top: 30px">
                @yield('content')
            </div>
        </div>



        <footer id="footer">
            
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
              
    
                    <div class="row p-3">
                   
                </div>

                <p><strong>Memorial do IME-USP</strong> <br>Um pequeno gesto para homenagear aqueles que contribuíram com o Instituto</p>

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
