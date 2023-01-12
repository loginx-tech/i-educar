@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('content')
    <form id="formcadastro" action="{{ route('sed.aluno.store', $codAluno) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Ficha Aluno</b></td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Nome *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNomeAluno') is-invalid @enderror"
                            type="text" name="inNomeAluno" id="name" required
                            value="{{ old('inNomeAluno') ? old('inNomeAluno') : $obj_pessoa_fj['nome'] }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Nome da Mãe *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNomeMae') is-invalid @enderror"
                            type="text" name="inNomeMae" id="name" required
                            {{-- value="{{ old('inNomeMae') ? old('inNomeMae') : '' }}" --}}
                            value="{{ old('inNomeMae') ? old('inNomeMae') : $det_fisica['nome_mae'] }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Data de Nascimento *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inDataNascimento') is-invalid @enderror"
                            type="date" name="inDataNascimento" id="name" style="width: 435px;" required
                            value="{{ old('inDataNascimento') ? old('inDataNascimento') : $obj_pessoa_fj['data_nasc'] }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Cor / Raça  *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCorRaca" id="inCorRaca" style="width: 435px;">
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\SedCorRacas::cases() as $raca)
                            <option value="{{ $raca->value }}" @if(old('inCorRaca') == $raca->value) selected @endif>
                                {{ $raca->getString($raca->value) }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Sexo *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inSexo" id="inSexo" style="width: 435px;">
                        <option value="">Selecione...</option>
                        <option value="1"
                            @if((old('inSexo') == "1" || old('inSexo') == 1))
                                selected
                            @else
                                @if($det_fisica['sexo'] == 'M')
                                    selected
                                @endif
                            @endif>
                            {{ 'Masculino' }}
                        </option>
                        <option value="2"
                            @if(old('inSexo') == "2" || old('inSexo') == 2)
                                selected
                            @else
                                @if($det_fisica['sexo'] == 'F')
                                    selected
                                @endif
                            @endif>
                            {{ 'Feminino' }}
                        </option>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Nacionalidade  *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inNacionalidade" id="inNacionalidade" style="width: 435px;">
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\SedNacionalidades::cases() as $nacionalidade)
                            <option value="{{ $nacionalidade->value }}"
                                @if(old('inNacionalidade') == $nacionalidade->value)
                                    selected
                                @else
                                    @if($det_fisica['nacionalidade'] == $nacionalidade->value)
                                        selected
                                    @endif
                                @endif>
                                {{ $nacionalidade->getString($nacionalidade->value) }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Data de Entrada no País (Obrigatório se estrangeiro)</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inDataEntradaPais') is-invalid @enderror"
                        value="
                            @if(old('inDataEntradaPais'))
                                {{ old('inDataEntradaPais') }}
                            @else
                                @if($det_fisica['data_chegada_brasil'])
                                    {{ $det_fisica['data_chegada_brasil'] }}
                                @endif
                            @endif
                            "
                            type="date" name="inDataEntradaPais" id="inDataEntradaPais" style="width: 435px;"
                            value="{{ old('inDataEntradaPais') ? old('inDataEntradaPais') : '' }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Municipio de Nascimento (Obrigatório se nacionalidade brasileira)</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNomeMunNascto') is-invalid @enderror"
                            type="text" name="inNomeMunNascto" id="inNomeMunNascto"
                            value="{{ old('inNomeMunNascto') ? old('inNomeMunNascto') : '' }}"
                            size="50" maxlength="60">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Estado(UF) de Nascimento (Obrigatório se nacionalidade brasileira)</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inUFMunNascto') is-invalid @enderror"
                            type="text" name="inUFMunNascto" id="inUFMunNascto"
                            value="{{ old('inUFMunNascto') ? old('inUFMunNascto') : '' }}"
                            size="50" maxlength="2">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Código País de Origem *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <select required class="geral" name="inCodPaisOrigem" id="inCodPaisOrigem" style="width: 435px;">
                        <option selected value="76">76 - (Brasil)</option>
                        {{-- @foreach(\App\Enums\SedNacionalidades::cases() as $nacionalidade)
                            <option value="{{ $nacionalidade->value }}" @if(old('inCodPaisOrigem') == $nacionalidade) selected @endif>
                                {{ $nacionalidade->getString($nacionalidade->value) }}
                            </option>
                        @endforeach --}}
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">País de Origem *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <select required class="geral" name="inPaisOrigem" id="inPaisOrigem" style="width: 435px;">
                        <option selected value="Brasil">Brasil</option>
                        {{-- @foreach(\App\Enums\SedNacionalidades::cases() as $nacionalidade)
                            <option value="{{ $nacionalidade->value }}" @if(old('inPaisOrigem') == $nacionalidade) selected @endif>
                                {{ $nacionalidade->getString($nacionalidade->value) }}
                            </option>
                        @endforeach --}}
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Possui Internet? *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inPossuiInternet" id="inPossuiInternet" style="width: 435px;">
                        <option value="">Selecione...</option>
                        <option value="S" @if(old('inPossuiInternet') == "S") selected @endif>
                            {{ 'Sim' }}
                        </option>
                        <option value="N" @if(old('inPossuiInternet') == "N") selected @endif>
                            {{ 'Não' }}
                        </option>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Possui Notebook, Smartphone ou Tablet? *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inPossuiNotebookSmartphoneTablet" id="inPossuiNotebookSmartphoneTablet" style="width: 435px;">
                        <option value="">Selecione...</option>
                        <option value="S" @if(old('inPossuiNotebookSmartphoneTablet') == "S") selected @endif>
                            {{ 'Sim' }}
                        </option>
                        <option value="N" @if(old('inPossuiNotebookSmartphoneTablet') == "N") selected @endif>
                            {{ 'Não' }}
                        </option>
                    </select>
                </td>
            </tr>

            {{-- <tr>
                <td class="formlttd" valign="top">
                    <span class="form">CPF</span><br>
                    <sub style="vertical-align:top;">nnn.nnn.nnn-nn</sub>
                </td>
                <td class="formlttd" valign="top">
                    <span class="form">
                        <input onkeypress="formataCPF(this, event);" type="text" name="cpf"
                               id="cpf"
                               size="16" maxlength="14" value="{{old('cpf', Request::get('cpf'))}}">
                    </span>
                </td>
            </tr> --}}
            </tbody>
        </table>

        <div class="separator"></div>

        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>

                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Endereço Residencial</b></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">CEP (Busca) *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inCep') is-invalid @enderror"
                                onblur="pesquisacep(this.value);"
                                type="text" name="inCep" id="inCep" required
                                value="{{ old('inCep') ? old('inCep') : (isset($obj_pessoa_fj['cep']) ? $obj_pessoa_fj['cep'] : '') }}"
                                size="50" maxlength="8">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Cidade *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inNomeCidade') is-invalid @enderror"
                                type="text" name="inNomeCidade" id="inNomeCidade" required
                                value="{{ old('inNomeCidade') ? old('inNomeCidade') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Estado(UF) *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inUFCidade') is-invalid @enderror"
                                type="text" name="inUFCidade" id="inUFCidade" required
                                value="{{ old('inUFCidade') ? old('inUFCidade') : '' }}"
                                size="50" maxlength="2">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Logradouro *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inLogradouro') is-invalid @enderror"
                                type="text" name="inLogradouro" id="inLogradouro" required
                                value="{{ old('inLogradouro') ? old('inLogradouro') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Número *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inNumero') is-invalid @enderror" style="width: 435px;" required
                                type="number" name="inNumero" id="inNumero"
                                value="{{ old('inNumero') ? old('inNumero') : $obj_pessoa_fj['numero'] }}"
                                size="50" minlength="0">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Complemento</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="opcional @error('inComplemento') is-invalid @enderror"
                                type="text" name="inComplemento" id="inComplemento"
                                value="{{ old('inComplemento') ? old('inComplemento') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Bairro *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inBairro') is-invalid @enderror"
                                type="text" name="inBairro" id="inBairro"
                                value="{{ old('inBairro') ? old('inBairro') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Area do Logradouro *</span>
                    </td>
                    <td class="formmdtd dd" valign="top">
                        <select required class="geral" name="inAreaLogradouro" id="inAreaLogradouro" style="width: 435px;">
                            <option value="">Selecione...</option>
                            <option value="0" @if(old('inAreaLogradouro') == "0") selected @endif>
                                {{ 'Urbana' }}
                            </option>
                            <option value="1" @if(old('inAreaLogradouro') == "1") selected @endif>
                                {{ 'Rural' }}
                            </option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Latitude *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inLatitude') is-invalid @enderror"
                                type="text" name="inLatitude" id="inLatitude"
                                value="{{ old('inLatitude') ? old('inLatitude') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Longitude *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inLongitude') is-invalid @enderror"
                                type="text" name="inLongitude" id="inLongitude"
                                value="{{ old('inLongitude') ? old('inLongitude') : '' }}"
                                size="50" maxlength="60">
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <div style="text-align: center">
            <button class="btn-green" type="submit">Enviar</button>
        </div>

    </form>

    <div class="separator"></div>

    </form>
@endsection

<script>
    // função executada ao carregar a página
    window.onload = function() {
        let inCep = document.getElementById('inCep').value;
        if(inCep != ''){
            pesquisacep(inCep);
        }
    }

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('inLogradouro').value=("");
        document.getElementById('inBairro').value=("");
        document.getElementById('inNomeCidade').value=("");
        document.getElementById('inUFCidade').value=("");
        document.getElementById('inLatitude').value=("");
        document.getElementById('inLongitude').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('inLogradouro').value=(conteudo.logradouro);
            document.getElementById('inBairro').value=(conteudo.bairro);
            document.getElementById('inNomeCidade').value=(conteudo.localidade);
            document.getElementById('inUFCidade').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('inLogradouro').value="...";
                document.getElementById('inBairro').value="...";
                document.getElementById('inNomeCidade').value="...";
                document.getElementById('inUFCidade').value="...";
                document.getElementById('inLatitude').value="...";
                document.getElementById('inLongitude').value="...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);

                fetch('https://maps.google.com/maps/api/geocode/json?address='+cep+'&key={{ config("sed.key") }}')
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById('inLatitude').value=(data.results[0].geometry.location.lat);
                        document.getElementById('inLongitude').value=(data.results[0].geometry.location.lng);
                    })
                    .catch((error) => alert('Erro ao buscar a latitude e longitude do CEP informado'));



            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

</script>

@prepend('scripts')
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend



