@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Salas')
@section('breadcrumb_url', route('intranet.page', 'educar_turma_lst.php'))

@section('content')
    <form id="formcadastro" action="{{ route('sed.remanejamento.store', [$aluno_ra, $sala_cod]) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Dados Básicos</b></td>
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
                    <span class="form">Sala de Destino *</span>
                </td>
                <td class="formmdtd dd" valign="top">
                    <select required class="geral" name="inNumClasseDestino" id="inNumClasseDestino" style="width: 435px;" required>
                        <option value="">Selecione...</option>
                        @foreach($sala_opcoes as $item)
                            <option value="{{ $item['outNumClasse'] }}"
                                @if(old('inNumClasseDestino') == $item['outNumClasse'])
                                    selected
                                @endif>
                                {{(
                                    $item['outDescSerieAno'] ?? '') . ' - ' .
                                    Str::upper($item['outTurma']) . ' - ' .
                                    $item['outDescricaoTurno'] . ' - ' .
                                    $item['outDescTipoEnsino']
                                }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>

            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Data de Efetiva do Remanejamento *</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio @error('inDataMovimento') is-invalid @enderror"
                            type="date" name="inDataMovimento" id="inDataMovimento" style="width: 435px;" required
                            value="{{ old('inDataMovimento') ? old('inDataMovimento') : '' }}"
                            size="50" maxlength="255">
                    </span>
                </td>
            </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <div style="text-align: center">
            <button class="btn-green" type="submit">Remanejar aluno</button>

            {{-- <a href="{{ route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass) }}">
                <button class="btn" type="button">Voltar</button>
            </a> --}}
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
