@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Salas')
@section('breadcrumb_url', route('intranet.page', 'educar_turma_lst.php'))

@section('content')
    <form id="formcadastro" action="{{ route('sed.class.store', $codClass) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Dados Básicos</b></td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Ano Letivo *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inAnoLetivo') is-invalid @enderror" style="width: 435px;" required
                            type="number" name="inAnoLetivo" id="inAnoLetivo" max="9999" min="0"
                            value="{{ old('inAnoLetivo') ? old('inAnoLetivo') : '' }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr>

            {{-- <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Código SED da Turma *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inNumClasse') is-invalid @enderror" style="width: 435px;" required
                            type="number" name="inNumClasse" id="inNumClasse" max="999999999" min="0"
                            value="{{ old('inNumClasse') ? old('inNumClasse') : '' }}"
                            size="50" minlength="0">
                    </span>
                </td>
            </tr> --}}

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
                                @endif>
                                {{ $item->outDescTipoEnsino }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            {{-- inCodSerieAno --}}
            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Serie / Ano *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodSerieAno" id="inCodSerieAno" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach($tiposEnsino as $item)
                            {{-- Exibe todos os anos/series de cada ensino --}}
                            @foreach ($item->outSerieAno as $serieAno)

                                @if (isset($serieAno->outDescSerieAno))
                                    <option value="{{ $serieAno->outCodSerieAno }}" data-ensino="{{ $item->outCodTipoEnsino }}"
                                        @if(old('inCodTipoClasse') == $serieAno->outCodSerieAno)
                                            selected
                                        @endif>
                                        {{ $item->outDescTipoEnsino . ' - ' . $serieAno->outDescSerieAno }}
                                    </option>
                                @endif

                            @endforeach

                        @endforeach
                    </select>
                </td>
            </tr>

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
                        placeholder="Turma (Ex. A, B, 1, 2, A1, B1)"
                            type="text" name="inTurma" id="inTurma"
                            value="{{ old('inTurma') ? old('inTurma') : '' }}"
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
                            value="{{ old('inNrCapacidadeFisicaMaxima') ? old('inNrCapacidadeFisicaMaxima') : '' }}"
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
                            placeholder="Com base no cadastro de dependências da escola"
                            type="number" name="inNumeroSala" id="inNumeroSala" max="999" min="0"
                            value="{{ old('inNumeroSala') ? old('inNumeroSala') : '' }}"
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
                    <td class="formdktd" colspan="2" height="24"><b>Definição de Datas Gerais</b></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Data de Ínicio das Aulas *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inDataInicioAula') is-invalid @enderror"
                                type="date" name="inDataInicioAula" id="inDataInicioAula" style="width: 435px;" required
                                value="{{ old('inDataInicioAula') ? old('inDataInicioAula') : '' }}"
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
                                value="{{ old('inDataFimAula') ? old('inDataFimAula') : '' }}"
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
                                value="{{ old('inHorarioInicioAula') ? old('inHorarioInicioAula') : '' }}"
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
                                value="{{ old('inHorarioFimAula') ? old('inHorarioFimAula') : '' }}"
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
                                    @endif>
                                    {{ $item->getString($item->value) }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>

                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Definição de Datas e Horários da Semana</b></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Segunda *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaSegunda') is-invalid @enderror"
                                type="time" name="inHoraIniAulaSegunda" id="inHoraIniAulaSegunda" style="width: 435px;" required
                                value="{{ old('inHoraIniAulaSegunda') ? old('inHoraIniAulaSegunda') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Segunda *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaSegunda') is-invalid @enderror"
                                type="time" name="inHoraFimAulaSegunda" id="inHoraFimAulaSegunda" style="width: 435px;" required
                                value="{{ old('inHoraFimAulaSegunda') ? old('inHoraFimAulaSegunda') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Terça *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaTerca') is-invalid @enderror"
                                type="time" name="inHoraIniAulaTerca" id="inHoraIniAulaTerca" style="width: 435px;" required
                                value="{{ old('inHoraIniAulaTerca') ? old('inHoraIniAulaTerca') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Terça *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaTerca') is-invalid @enderror"
                                type="time" name="inHoraFimAulaTerca" id="inHoraFimAulaTerca" style="width: 435px;" required
                                value="{{ old('inHoraFimAulaTerca') ? old('inHoraFimAulaTerca') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Quarta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaQuarta') is-invalid @enderror"
                                type="time" name="inHoraIniAulaQuarta" id="inHoraIniAulaQuarta" style="width: 435px;" required
                                value="{{ old('inHoraIniAulaQuarta') ? old('inHoraIniAulaQuarta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Quarta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaQuarta') is-invalid @enderror"
                                type="time" name="inHoraFimAulaQuarta" id="inHoraFimAulaQuarta" style="width: 435px;" required
                                value="{{ old('inHoraFimAulaQuarta') ? old('inHoraFimAulaQuarta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Quinta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaQuinta') is-invalid @enderror"
                                type="time" name="inHoraIniAulaQuinta" id="inHoraIniAulaQuinta" style="width: 435px;" required
                                value="{{ old('inHoraIniAulaQuinta') ? old('inHoraIniAulaQuinta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Quinta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaQuinta') is-invalid @enderror"
                                type="time" name="inHoraFimAulaQuinta" id="inHoraFimAulaQuinta" style="width: 435px;" required
                                value="{{ old('inHoraFimAulaQuinta') ? old('inHoraFimAulaQuinta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Sexta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaSexta') is-invalid @enderror"
                                type="time" name="inHoraIniAulaSexta" id="inHoraIniAulaSexta" style="width: 435px;" required
                                value="{{ old('inHoraIniAulaSexta') ? old('inHoraIniAulaSexta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Sexta *</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaSexta') is-invalid @enderror"
                                type="time" name="inHoraFimAulaSexta" id="inHoraFimAulaSexta" style="width: 435px;" required
                                value="{{ old('inHoraFimAulaSexta') ? old('inHoraFimAulaSexta') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Inicio Sábado</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraIniAulaSabado') is-invalid @enderror"
                                type="time" name="inHoraIniAulaSabado" id="inHoraIniAulaSabado" style="width: 435px;"
                                value="{{ old('inHoraIniAulaSabado') ? old('inHoraIniAulaSabado') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Horário de Fim Sábado</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inHoraFimAulaSabado') is-invalid @enderror"
                                type="time" name="inHoraFimAulaSabado" id="inHoraFimAulaSabado" style="width: 435px;"
                                value="{{ old('inHoraFimAulaSabado') ? old('inHoraFimAulaSabado') : '' }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <div style="text-align: center">
            <button class="btn-green" type="submit">Criar cadastro SED</button>
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
