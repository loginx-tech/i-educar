@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Salas')
@section('breadcrumb_url', route('intranet.page', 'educar_turma_lst.php'))


@section('content')
    <form id="formcadastro" action="{{ route('sed.class.update', $codClass) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Dados Básicos</b></td>
            </tr>

            {{-- <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Ano Letivo *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNomeAluno') is-invalid @enderror"
                            type="text" name="inNomeAluno" id="name" required
                            value="{{ old('inNomeAluno') ? old('inNomeAluno') : $obj_pessoa_fj['nome'] }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr> --}}

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Ano Letivo *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inAnoLetivo') is-invalid @enderror" style="width: 435px;" required
                            type="number" name="inAnoLetivo" id="inAnoLetivo" max="9999" min="0"
                            value="{{ old('inAnoLetivo') ? old('inAnoLetivo') : $class['outAnoLetivo'] }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Código SED da Turma </span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNumClasse') is-invalid @enderror" style="width: 435px;" disabled
                            type="number" name="inNumClasse" id="inNumClasse" max="999999999" min="0"
                            value="{{ old('inNumClasse') ? old('inNumClasse') : $class['outCodTurmaClasse'] }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr>

            {{-- Aqui seta cod da escola e no back pega a unidade first junto - inCodUnidade --}}
            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Escola *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodEscola" id="inCodEscola" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach($escolas as $item)
                            <option value="{{ $item['sigla'] }}"
                                @if(old('inCodEscola') == $item['sigla'])
                                    selected
                                @else
                                    @if($item['sigla'] == $class['outCodEscola'])
                                        selected
                                    @endif
                                @endif>
                                {{ $item['nome'] }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Tipo de Ensino *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodTipoEnsino" id="inCodTipoEnsino" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach($tiposEnsino as $item)
                            <option value="{{ $item->outCodTipoEnsino }}"
                                @if(old('inCodTipoEnsino') == $item->outCodTipoEnsino)
                                    selected
                                @else
                                    @if($item->outCodTipoEnsino == $class['outCodTipoEnsino'])
                                        selected
                                    @endif
                                @endif>
                                {{ $item->outDescTipoEnsino }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            {{-- inCodSerieAno --}}
            {{-- <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Tipo de Ensino *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodSerieAno" id="inCodSerieAno" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\SerieAno::cases() as $item)
                            <option value="{{ $item->value }}"
                                @if(old('inCodSerieAno') == $item->value)
                                    selected
                                @endif>
                                {{ $item->getString($item->value) }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr> --}}

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Tipo de Classe *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodTipoClasse" id="inCodTipoClasse" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach($tiposClasse as $item)
                            <option value="{{ $item->outCodTipoClasse }}"
                                @if(old('inCodTipoClasse') == $item->outCodTipoClasse)
                                    selected
                                @else
                                    @if($item->outCodTipoClasse == $class['outCodTipoClasse'])
                                        selected
                                    @endif
                                @endif>
                                {{ $item->outDescTipoClasse }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Turno *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodTurno" id="inCodTurno" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\Turnos::cases() as $item)
                        <option value="{{ $item->value }}"
                            @if(old('inCodTurno') == $item->value)
                                selected
                            @else
                                @if($class['outCodTurno'] == $item->value)
                                    selected
                                @endif
                            @endif>
                            {{ $item->getString($item->value) }}
                        </option>
                    @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Sigla</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inTurma') is-invalid @enderror"
                            type="text" name="inTurma" id="inTurma"
                            value="{{ old('inTurma') ? old('inTurma') : $class['outTurma'] }}"
                            size="50" maxlength="2">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Capacidade Física Maxima *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNrCapacidadeFisicaMaxima') is-invalid @enderror" style="width: 435px;" required
                            type="number" name="inNrCapacidadeFisicaMaxima" id="inNrCapacidadeFisicaMaxima" max="99" min="0"
                            value="{{ old('inNrCapacidadeFisicaMaxima') ? old('inNrCapacidadeFisicaMaxima') : $class['outNrCapacidadeFisicaMaxima'] }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Número da Sala *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNumeroSala') is-invalid @enderror" style="width: 435px;" required
                            type="number" name="inNumeroSala" id="inNumeroSala" max="999" min="0"
                            value="{{ old('inNumeroSala') ? old('inNumeroSala') : $class['outNumeroSala'] }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr>




            </tbody>
        </table>

        <div class="separator"></div>

        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>

                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Definição de Datas e Horários</b></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Data de Ínicio das Aulas *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inDataInicioAula') is-invalid @enderror"
                                type="date" name="inDataInicioAula" id="inDataInicioAula" style="width: 435px;" required
                                value="{{ old('inDataInicioAula') ? old('inDataInicioAula') : \Carbon\Carbon::createFromFormat('d/m/Y', $class['outDataInicioAula'])->format('Y-m-d') }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Data de Término das Aulas *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inDataFimAula') is-invalid @enderror"
                                type="date" name="inDataFimAula" id="inDataFimAula" style="width: 435px;" required
                                value="{{ old('inDataFimAula') ? old('inDataFimAula') : \Carbon\Carbon::createFromFormat('d/m/Y', $class['outDataFimAula'])->format('Y-m-d') }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHorarioInicioAula') is-invalid @enderror"
                                type="time" name="inHorarioInicioAula" id="inHorarioInicioAula" style="width: 435px;" required
                                value="{{ old('inHorarioInicioAula') ? old('inHorarioInicioAula') : $class['outHorarioInicioAula'] }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>


                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Término *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHorarioFimAula') is-invalid @enderror"
                                type="time" name="inHorarioFimAula" id="inHorarioFimAula" style="width: 435px;" required
                                value="{{ old('inHorarioFimAula') ? old('inHorarioFimAula') : $class['outHorarioFimAula'] }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Duração da Turma *</span>
                    </td>
                    <td class="formmdtd dd" valign="top">
                        <select required class="geral" name="inCodDuracao" id="inCodDuracao" style="width: 435px;">
                            <option value="">Selecione...</option>
                            @foreach(\App\Enums\Sed\SalaDuracao::cases() as $item)
                                <option value="{{ $item->value }}"
                                    @if(old('inCodDuracao') == $item->value)
                                        selected
                                    @else
                                        @if($class['outCodDuracao'] == $item->value)
                                            selected
                                        @endif
                                    @endif>
                                    {{ $item->getString($item->value) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

            </tbody>
        </table>

        {{-- TO-DO: colocar tabela de dias da semana aqui --}}

        <div class="separator"></div>

        <div style="text-align: center">
            <button class="btn-green" type="submit">Atualizar cadastro SED</button>
        </div>

    </form>

    <div class="separator"></div>

@endsection

@prepend('scripts')
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend
