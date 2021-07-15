<form action="/homenageados/{{$homenageado->id}}" method="POST">
    @csrf
    @method('patch')
    @include('homenageados.partials.form')
</form>