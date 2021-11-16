@include('main')

@section('content')
    Nome: {{$mensagem->nome}} <br>
    Email: {{$mensagem->email}} <br>
    Instituição: {{$mensagem->instituicao}} <br>
    Mensagem: {{$mensagem->mensagem}} <br>

    <a href="/mensagems/validar/{{$mensagem->id}}/aceitar" class="btn btn-success">Aceitar</a>  
    <a href="/mensagems/validar/{{$mensagem->id}}/negar" class="btn btn-warning">Negar</a>
    <a href="/mensagems/validar/{{$mensagem->id}}/deletar" class="btn btn-danger">Deletar</a>
@endsection



