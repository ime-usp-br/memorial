
<form action="/admin/removercurador" method="post">
    @csrf
    <form>
        <div class="form-group">
            <label for="remover_curador">Selecione o número USP do curador a ser removido:</label>
            <select class="form-control" id="remover_curador" name="curador">
                <option value="" selected=""> - Selecione  -</option>
                @foreach ($curadores as $curador)
                    <option value="{{$curador->codpes}}">
                        {{$curador->codpes}}
                    </option> 
                @endforeach
            </select>
        </div>
        <br>

        <input type="hidden" name="homenageado_id" value="{{$homenageado_id}}">
    
        <button class="btn btn-danger" type="submit">Remover</button>
    </form>
</form>

