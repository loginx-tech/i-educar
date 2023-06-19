@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Salas')
@section('breadcrumb_url', route('intranet.page', 'educar_turma_lst.php'))

@section('content')
    <form id="formcadastro" action="{{ route('sed.transferencia.store', [$aluno_ra, $sala_cod]) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Dados Básicos - Transferência</b></td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Aluno</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio" disabled
                            type="text" name="inAlunoData" id="inAlunoData"
                            value="{{ $aluno['outDadosPessoais']['outNomeAluno'] . ' - RA ' . $aluno['outDadosPessoais']['outNumRA'] }}"
                            size="50" maxlength="2">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Turma Atual</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio" disabled
                            type="text" name="inAlunoData" id="inAlunoData"
                            value="{{ $sala_atual['outDescricaoTurma'] }}"
                            size="50" maxlength="2">
                    </span>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Escola *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inCodEscola" id="inCodEscola" style="width: 438px;">
                        <option value="">Selecione...</option>
                        @foreach($escolas as $item)
                            <option value="{{ $item['outCodEscola'] }}"
                                @if(old('inCodEscola') == $item['outCodEscola'])
                                    selected
                                @endif>
                                {{(
                                    $item['outDescNomeEscola'] ?? 'Indefinido')
                                }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Tipo de Transferência *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inFase" id="inFase" style="width: 438px;">
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\Transferencia\TipoTransferenciaEnum::cases() as $enum)
                            <option value="{{ $enum->value }}"
                                @if(old('inFase') == $enum->value )
                                    selected
                                @endif>
                                {{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Motivo *</span>
                </td>
                <td class="formmdtd dd" valign="top">

                    <select
                        required class="geral" name="inMotivo" id="inMotivo_GENERIC" disabled
                        @if(old('inFase'))
                            style="width: 438px; display: none;"
                        @else
                            style="width: 438px;"
                        @endif
                    >
                        <option value="">Selecione um tipo de transferência antes...</option>
                    </select>

                    <select
                        required class="geral" name="inMotivo" id="inMotivo_TRANSFERENCIA"
                        @if(old('inFase') != \App\Enums\Sed\Transferencia\TipoTransferenciaEnum::TRANSFERENCIA->value)
                            disabled
                            style="width: 438px; display: none;"
                        @else
                            style="width: 438px;"
                        @endif
                    >
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\Transferencia\MotivosEnum::casesTransferencia(0) as $enum)
                            <option value="{{ $enum->getCod() }}"
                                @if(old('inMotivo') == $enum->getCod())
                                    selected
                                @endif>
                                {{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        required class="geral" name="inMotivo" id="inMotivo_DESLOCAMENTO"
                        @if(old('inFase') != \App\Enums\Sed\Transferencia\TipoTransferenciaEnum::DESLOCAMENTO->value)
                            disabled
                            style="width: 438px; display: none;"
                        @else
                            style="width: 438px;"
                        @endif
                    >
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\Transferencia\MotivosEnum::casesDescolamento(0) as $enum)
                            <option value="{{ $enum->getCod() }}"
                                @if(old('inMotivo') == $enum->getCod() )
                                    selected
                                @endif>
                                {{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>

                    <select
                        required class="geral" name="inMotivo" id="inMotivo_INTENCAO"
                        @if(old('inFase') != \App\Enums\Sed\Transferencia\TipoTransferenciaEnum::INTENCAO->value)
                            disabled
                            style="width: 438px; display: none;"
                        @else
                            style="width: 438px;"
                        @endif
                    >
                        <option value="">Selecione...</option>
                        @foreach(\App\Enums\Sed\Transferencia\MotivosEnum::casesIntencao(0) as $enum)
                            <option value="{{ $enum->getCod() }}"
                                @if(old('inMotivo') == $enum->getCod() )
                                    selected
                                @endif>
                                {{ $enum->toString() }}
                            </option>
                        @endforeach
                    </select>

                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Possuí interesse no turno integral ?</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select class="geral" name="inInteresseIntegral" id="inInteresseIntegral" style="width: 438px;">
                        <option value="0" selected>NÃO POSSUÍ INTERESSE</option>
                        <option value="1"
                            @if(old('inInteresseIntegral') == 1 )
                                selected
                            @endif>
                            SIM, POSSUÍ INTERESSE
                        </option>
                    </select>
                </td>
            </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <div style="text-align: center">
            <button class="btn-green" type="submit">Selecionar</button>

            {{-- <a href="{{ route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass) }}">
                <button class="btn" type="button">Voltar</button>
            </a> --}}
        </div>

    </form>

    <div class="separator"></div>

@endsection

@prepend('scripts')
    <script type="text/javascript"
        src="{{ Asset::get("/vendor/legacy/Sed/Assets/HandleMotivoTransferencia.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend
