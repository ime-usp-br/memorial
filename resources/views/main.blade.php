<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorial</title>
    <link rel="stylesheet" href="{{asset('site/style.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
</head>
<body>
    <div id="app">
        <div id="content">
            <br>
            <div class="row justify-content-center">
                <div class="col-1">
                    <a href="/" target="_blank" >
                        <img src="{{ asset("img/logo_ime.png") }}">
                    </a>
                </div>
                <div class="col-3">
                    <b>Memorial</b> <br>
                    Instituto de Matemática e Estatística <br>
                    Universidade de São Paulo
                </div>

            </div>
            <br>
            <div class="row justify-content-center" style="background-color: #666666; padding: 10px;">
                <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active text-white" href="/"><i class="cil-home"></i> Página inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/">Homenageados</a>
                </li>
                <li class="nav-item">
                    @if(Auth::user() == null)
                        <a class="nav-link text-white" href="/login"><i class="cil-account-logout"></i> Login</a>
                    @else
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-white btn btn-link"><i class="cil-account-logout"></i> Logout</button>
                        </form> 
                    @endif
                </li>
                </ul>
            </div>
            
            <div class="container">
                @yield('content')
            </div>
        </div>
        
        

        <footer id="footer" style="background-color: #eeeeee; padding: 10px;">
        <div class="container" >


            <div class="row">
            <div class="col-md-1">
                <a href="http://www.ime.usp.br" target="_blank" >
                <img src="{{ asset("img/logo_ime.png") }}">
                </a>
            </div>
            <div class="col-md-4">
                <b>Memorial</b>

                <br><a href="http://www.ime.usp.br">Instituto de Matemática e Estatística</a>
                <br><a href="http://www.usp.br">Universidade de São Paulo</a>
                <br><a href="https://uspdev.github.io/"><span>&copy; 2021 USPDev</span></a>

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
                @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a>
                </p>
                @endif
            @endforeach
        </div>
            
        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
        <script src="{{asset('site/jquery.js')}}"></script>
        <script src="{{asset('site/bootstrap.js')}}"></script>
    </div>
    
</body>
</html>




