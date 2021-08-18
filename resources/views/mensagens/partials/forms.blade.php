Nome: <input type="text" name="nome" value="{{old('nome', $mensagem->nome)}}"> <br>
Email: <input type="email" name="email" value="{{old('email', $mensagem->email)}}"> <br>
Instituição: <input type="text" name="instituicao" value="{{old('instituicao', $mensagem->instituicao)}}"> <br>
<input type="hidden" name="homenageado_id" value="{{$homenageado_id}}">
Mensagem: <br>
<textarea name="mensagem" cols="30" rows="10">{{old('mensagem', $mensagem->mensagem)}}</textarea> <br>
@if($edit)
    <select name="estado">
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
    <input type="text" id="CaptchaCode" name="CaptchaCode"> <br><br><br>
@endif



<button type="submit">Enviar</button> <br>
