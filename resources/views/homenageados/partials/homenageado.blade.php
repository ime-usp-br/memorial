<img width="500px" src="/fotos/{{$fotoPerfil->id}}"> <br>

Nome: {{$homenageado->nome}} <br>
Data de Nasciemento: {{(new Datetime($homenageado->data_nascimento))->format('d/m/Y')}} <br>
Data de Falecimento: {{(new Datetime($homenageado->data_falecimento))->format('d/m/Y')}} <br>

Biografia: <br>
{{$homenageado->biografia}}



