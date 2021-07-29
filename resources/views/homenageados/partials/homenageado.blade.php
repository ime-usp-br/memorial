@if($fotoPerfil != null)
    <img width="500px" src="/fotos/{{$fotoPerfil->id}}"> <br>
@endif

Nome: {{$homenageado->nome}} <br>
Data de Nasciemento: {{$homenageado->data_nascimento}} <br>
Data de Falecimento: {{$homenageado->data_falecimento}} <br>

Biografia: <br>
{{$homenageado->biografia}}

