@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Salas')
@section('breadcrumb_url', route('intranet.page', 'educar_turma_lst.php'))

@section('content')
    <form id="formcadastro" action="" method="post">
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Dados da Turma no SED</b></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Turma</span></td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            {{
                                $class['outDescTipoEnsino'] ?? ''
                            }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Serie</span></td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            {{
                                ($class['outCodSerieAno'] ?? '') . 'º ' .
                                (Str::upper($class['outTurma'] ?? ''))
                                . ' - ' .
                                ($class['outDescricaoTurno'] ?? '')
                            }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Código SED da Turma</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outNumClasse'] ?? '-' }}</span></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Capacidade Física da Sala</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outCapacidadeFisicaMax'] ?? '-' }}</span></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Quantidade Atual de Alunos</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdAtual'] ?? '-' }}</span></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Quantidade de Alunos Matriculados</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdDigitados'] ?? '-' }}</span></td>
                </tr>

                {{-- <tr>
                    <td class="formmdtd" valign="top"><span class="form">Quantidade Alunos Evadidos</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdEvadidos'] ?? '-' }}</span></td>
                </tr> --}}

                {{-- <tr>
                    <td class="formmdtd" valign="top"><span class="form">Quantidade Alunos em Não Comparecimento</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdNCom'] ?? '-' }}</span></td>
                </tr> --}}

                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Quantidade de Alunos Transferidos</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdTransferidos'] ?? '-' }}</span></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Quantidade de Alunos Remanejados</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdRemanejados'] ?? '-' }}</span></td>
                </tr>

                {{-- <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Quantidade Alunos Cessados</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdCessados'] ?? '-' }}</span></td>
                </tr> --}}

                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Quantidade de Alunos Reclassificados</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class['outQtdReclassificados'] ?? '-' }}</span></td>
                </tr>

                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Quantidade de Alunos em Outras Situações</td>
                    <td class="formmdtd" valign="top"><span class="form">
                        {{
                            (($class['outQtdOutros'] ?? 0) + ($class['outQtdCessados'] ?? 0) + ($class['outQtdEvadidos'] ?? 0) + ($class['outQtdNCom'] ?? 0))
                        }}
                        </span>
                    </td>
                </tr>

                {{-- <tr>
                    <td class="formmdtd" valign="top"><span class="form">Descrição da rede de ensino</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $class->outDescTipoEnsino ?? '' }}</span></td>
                </tr> --}}
            </tbody>
        </table>
    </form>

    <div class="separator"></div>

    <div style="text-align: center">
            <a href="{{ route('sed.class.edit', $codClass) }}">
                <button class="btn-green" type="button">Editar Cadastro SED</button>
            </a>
            <a href="{{ route('student-log-unification.undo', ['unification' => $codClass]) }}">
                <button class="btn-green" type="button">Alterar Vínculo de Codigo SED</button>
            </a>

        <a href="{{ route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass) }}">
            <button class="btn" type="button">Voltar</button>
        </a>
    </div>

    <div class="separator" style="margin-top: 10px"></div>

    <form id="formcadastro" action="" method="post" style="margin-bottom: 40px">
        <table class="tablecadastro p" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="4" height="24"><b>Alunos</b></td>
                </tr>

                <tr>
                    <td class="formmdtd bold" valign="top"><span class="form"><b>Aluno</b></span></td>
                    <td class="formmdtd bold" valign="top"><span class="form"><b>RA</b></span></td>
                    <td class="formmdtd bold" valign="top"><span class="form"><b>Situação Matricula</b></span></td>
                    <td class="formmdtd bold" valign="top"><span class="form"><b>Ações</b></span></td>
                </tr>

                @forelse ($class['outAlunos'] as $student)
                    <tr>
                        <td class="formmdtd" valign="top"><span class="form">{{ $student['outNomeAluno'] ?? '-' }}</span></td>
                        <td class="formmdtd" valign="top"><span class="form">{{ $student['outNumRA'] ? $student['outNumRA'].'-'.$student['outDigitoRA'] : '-' }}</span></td>
                        <td class="formmdtd" valign="top"><span class="form">{{ $student['outDescSitMatricula'] ?? '-' }}</span></td>
                        <td class="formmdtd" valign="top">
                            <span class="form">
                                -
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="formdktd" colspan="3" valign="top"><span class="form">Não há alunos matriculados na turma</span></td>
                    </tr>
                @endforelse

            </tbody>
        </table>
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
