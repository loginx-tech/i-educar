@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Alunos')
@section('breadcrumb_url', url('/intranet/educar_aluno_lst.php'))

@section('content')
    <form id="formcadastro" action="{{ route('sed.matricula.store', [$codMatricula, $codAluno]) }}" method="post">
        @csrf
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Matricular Aluno</b></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Ano Letivo</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inAnoLetivo') is-invalid @enderror" style="width: 435px;"
                                type="number" name="inAnoLetivo" id="inAnoLetivo" max="9999" min="0"
                                value="{{ old('inAnoLetivo') ? old('inAnoLetivo') : date('Y') }}"
                                size="50" minlength="0" disabled>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Data de Matrícula</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inDataInicioAula') is-invalid @enderror"
                                type="date" name="inDataInicioAula" id="inDataEnturmacao" style="width: 435px;" disabled
                                value="{{ $enturmacoes['data_enturmacao'] }}"
                                size="50" maxlength="255">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Aluno</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inTurma') is-invalid @enderror"
                                type="text" id="alunoInput" disabled
                                value="{{ $aluno['nome_aluno'] . " - " . $codAluno }}"
                                size="50" maxlength="2">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Escola</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inTurma') is-invalid @enderror"
                                type="text" name="inTurma" id="escolaInput" disabled
                                value="{{ $matricula['ref_ref_cod_escola'] }}"
                                size="50" maxlength="2">
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top">
                        <span class="form">Turma</span>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <input class="obrigatorio @error('inTurma') is-invalid @enderror"
                                type="text" name="inTurma" id="turmaInput" disabled
                                value="{{ $enturmacoes['nm_turma'] }}"
                                size="50" maxlength="2">
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="separator"></div>

        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Verifique se os dados estão corretos, antes de submeter a matrícula ao SED</b></td>
                </tr>
            </tbody>
        </table>


        <div style="text-align: center">
            <button class="btn-green" type="submit">Enviar</button>
        </div>

    </form>

    <div class="separator"></div>

    </form>
@endsection

@prepend('scripts')
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend
