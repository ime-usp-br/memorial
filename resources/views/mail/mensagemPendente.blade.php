<b>Nova mensagem no sistema Memorial para {{$homenageado->nome}}:</b> <br><br>

Nome: {{$mensagem->nome}} <br>
Email: {{$mensagem->email}} <br>
Instituição: {{$mensagem->instituicao}} <br>
Mensagem: {{$mensagem->mensagem}} <br>

<br>

<div class="btn-group">
<a href="{{env('APP_URL')}}/mensagems/validar/{{$mensagem->id}}/{{$token}}/aceitar" class="btn btn-success">Aceitar</a>  
<a href="{{env('APP_URL')}}/mensagems/validar/{{$mensagem->id}}/{{$token}}/negar" class="btn btn-warning">Negar</a>
</div>
