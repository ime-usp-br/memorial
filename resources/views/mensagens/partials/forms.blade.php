<form>
    <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control" type="text" id="nome" name="nome" value="{{old('nome', $mensagem->nome)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email" value="{{old('email', $mensagem->email)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="instituicao">Instituição</label>
        <input class="form-control" type="text" id="instituicao" name="instituicao" value="{{old('instituicao', $mensagem->instituicao)}}">
    </div>
    <br>
    <div class="form-group">
        <label for="mensagem">Mensagem</label>
        <textarea class="form-control" id="mensagem" name="mensagem" cols="30" rows="10">{{old('mensagem', $mensagem->mensagem)}}</textarea> 
    </div>

    <br>
    <div class="form-group">
        @if($edit)
        <label for="estado">Estado</label>
        <select class="form-control" id="estado" name="estado">
            <option value="" selected=""> - Selecione  -</option>
            @foreach ($mensagem->estados() as $estado)
                {{-- 1. Situação em que não houve tentativa de submissão --}}
                @if (old('estado') == '')
                <option value="{{$estado}}" {{ ( $mensagem->estado == $estado) ? 'selected' : ''}}>
                    {{$estado}}
                </option>
                {{-- 2. Situação em que houve tentativa de submissão, o valor de old prevalece --}}
                @else
                    <option value="{{$estado}}" {{ ( old('estado') == $estado) ? 'selected' : ''}}>
                        {{$estado}}
                    </option>
                @endif
            @endforeach
        </select>
        @else
        {!! captcha_image_html('MensagemCaptcha') !!}
        <input type="text" id="CaptchaCode" name="CaptchaCode"> 
        @endif
    </div>
    <br>
    <input type="hidden" name="homenageado_id" value="{{ $homenageado_id }}">
    <div class="btn-group">
        <button type="submit" class="btn btn-outline-dark">Salvar</button>
        @if($edit)
        <a href="/mensagems/delete/{{ $mensagem->id }}" class="btn btn-outline-dark" onclick="return confirm('Tem certeza?');">Apagar</a>
        @endif
    </div>
    
</form>
