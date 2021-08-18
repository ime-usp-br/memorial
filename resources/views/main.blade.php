<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorial</title>
    <link rel="stylesheet" href="{{asset('site/style.css')}}">
</head>
<body>
    

    <script src="{{asset('site/jquery.js')}}"></script>
    <script src="{{asset('site/bootstrap.js')}}"></script>

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
</body>
</html>




