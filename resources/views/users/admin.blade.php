@extends('main')

@section('content')
<strong><h4>Administradores:</h4></strong>

<ul>
    @foreach($admins as $admin)
    <li>
        <strong>{{ $admin->name }} - {{$admin->codpes}}</strong>
        @if(Auth::user()->id != $admin->id)
        [ <a class="link-dark text-decoration-none" href="/admin/removerAdmin/{{$admin->id}}" onclick="return confirm('Tem certeza?');">remover</a> ]
        @endif
    </li>
    @endforeach
</ul>

<button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#admin">Adicionar administrador</button>

<div class="modal fade" id="admin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar administrador</h4>
                <button type="button"  data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @include('users.novoadmin')
            </div>
            
        </div>
    </div>
</div>
@endsection


