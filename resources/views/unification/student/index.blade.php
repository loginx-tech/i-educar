@extends('layout.default')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('content')
    <form id="formcadastro" action="" method="get">
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
            <tr>
                <td class="formdktd" colspan="2" height="24"><b>Unificação de alunos</b></td>
            </tr>
            <tr id="tr_nm_instituicao">
                <td class="formmdtd" valign="top"><span class="form">Instituição:</span></td>
                <td class="formmdtd" valign="top">
                    @include('form.select-institution')
                </td>
            </tr>
            <tr id="tr_nm_escola">
                <td class="formlttd" valign="top"><span class="form">Escola:</span></td>
                <td class="formlttd" valign="top">
                    @include('form.select-school')
                </td>
            </tr>
            <tr>
                <td class="formmdtd" valign="top">
                    <span class="form">Nome do aluno:</span>
                </td>
                <td class="formmdtd" valign="top">
                    <span class="form">
                        <input class="obrigatorio" type="text" name="name" id="name" value="{{old('name', Request::get('name'))}}" size="50" maxlength="255">
                    </span>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="separator"></div>
        <form id="formcadastro" action="" method="post">
            <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
                <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Atualização de boletins em lote</b></td>
                </tr>
                <tr id="tr_nm_ano">
                    <td class="formmdtd" valign="top">
                        <span class="form">Ano</span>
                        <span class="campo_obrigatorio">*</span>
                        <br>
                        <sub style="vertical-align:top;">somente números</sub>
                    </td>
                    <td class="formmdtd" valign="top">
                        @include('form.select-year')
                    </td>
                </tr>
                <tr id="tr_nm_instituicao">
                    <td class="formlttd" valign="top">
                        <span class="form">Instituição</span>
                        <span class="campo_obrigatorio">*</span>
                    </td>
                    <td class="formlttd" valign="top">
                        @include('form.select-institution')
                    </td>
                </tr>
                <tr id="tr_nm_escola">
                    <td class="formmdtd" valign="top"><span class="form">Escola</span></td>
                    <td class="formmdtd" valign="top">
                        @include('form.select-school')
                    </td>
                </tr>
                <tr id="tr_nm_curso">
                    <td class="formlttd" valign="top"><span class="form">Curso</span></td>
                    <td class="formlttd" valign="top">
                        <span class="form">
                            <select class="geral" name="ref_cod_curso" id="ref_cod_curso" data-refresh-ano="false" style="width: 308px;">
                                <option value="">Selecione um curso</option>
                            </select>
                        </span>

                        @if(old('ref_cod_curso', Request::get('ref_cod_curso')))
                            @push('scripts')
                                <script>
                                    (function ($) {
                                        $(document).ready(function () {
                                            $j('#ref_cod_curso').val({{old('ref_cod_curso', Request::get('ref_cod_curso'))}})
                                        });
                                    })(jQuery);
                                </script>
                            @endpush
                        @endif

                    </td>
                </tr>
                <tr id="tr_nm_serie">
                    <td class="formmdtd" valign="top"><span class="form">Série</span></td>
                    <td class="formmdtd" valign="top">
                        @include('form.select-grade-multiple')
                    </td>
                </tr>

                <tr id="tr_nm_tipo_boletim">
                    <td class="formlttd" valign="top">
                        <span class="form">Modelo de boletim antigo</span>
                        <br>
                        <sub style="vertical-align:top;">Deixe em branco para atualizar em todas as turmas</sub>
                    </td>
                    <td class="formlttd" valign="top">
                        <span class="form">
                            <select class="geral" name="old_report_card" id="old_report_card" style="width: 308px;">
                                <option value="">Selecione um tipo</option>

                            </select>
                        </span>
                        @if(old('old_report_card', Request::get('old_report_card')))
                            @push('scripts')
                                <script>
                                    (function ($) {
                                        $(document).ready(function () {
                                            $j('#old_report_card').val({{old('old_report_card', Request::get('old_report_card'))}})
                                        });
                                    })(jQuery);
                                </script>
                            @endpush
                        @endif
                    </td>
                </tr>

                <tr id="tr_nm_tipo_boletim">
                    <td class="formmdtd" valign="top">
                        <span class="form">Novo modelo de boletim</span>
                        <br>
                        <sub style="vertical-align:top;">Deixe em branco para não alterar</sub>
                    </td>
                    <td class="formmdtd" valign="top">
                        <span class="form">
                            <select class="geral" name="new_report_card" id="new_report_card" style="width: 308px;">
                                <option value="">Selecione um tipo</option>

                            </select>
                        </span>
                        @if(old('new_report_card', Request::get('new_report_card')))
                            @push('scripts')
                                <script>
                                    (function ($) {
                                        $(document).ready(function () {
                                            $j('#new_report_card').val({{old('new_report_card', Request::get('new_report_card'))}})
                                        });
                                    })(jQuery);
                                </script>
                            @endpush
                        @endif
                    </td>
                </tr>
                <tr id="tr_nm_tipo_boletim">
                    <td class="formlttd" valign="top">
                        <span class="form">Novo modelo de boletim (diferenciado)</span>
                        <br>
                        <sub style="vertical-align:top;">Deixe em branco para não alterar</sub>
                    </td>
                    <td class="formlttd" valign="top">
                        <span class="form">
                            <select class="geral" name="new_alternative_report_card" id="new_alternative_report_card" style="width: 308px;">
                                <option value="">Selecione um tipo</option>
                            </select>
                        </span>
                        @if(old('new_alternative_report_card', Request::get('new_alternative_report_card')))
                            @push('scripts')
                                <script>
                                    (function ($) {
                                        $(document).ready(function () {
                                            $j('#new_alternative_report_card').val({{old('new_alternative_report_card', Request::get('new_alternative_report_card'))}})
                                        });
                                    })(jQuery);
                                </script>
                            @endpush
                        @endif
                    </td>
                </tr>

                </tbody>
            </table>

            <div style="text-align: center">
                <button class="btn-green" type="submit">Salvar</button>
            </div>

        </form>

        @if(Session::has('classrooms'))
            <h3>Turmas alteradas</h3>
            <br>
            <table class="table-default">
                <thead>
                <tr>
                    <th>Código da turma</th>
                    <th>Nome da turma</th>
                    @isset(Session::get('classrooms')[0]['new_report'])
                    <th>Modelo de boletim antigo</th>
                    <th>Novo modelo de boletim</th>
                    @endisset
                    @isset(Session::get('classrooms')[0]['new_alternative_report'])
                        <th>Modelo de boletim antigo (diferenciado)</th>
                        <th>Novo modelo de boletim (diferenciado)</th>
                    @endisset
                </tr>
                </thead>
                <tbody>
                @foreach(Session::get('classrooms') as $classroom)
                    <tr class="form-success">
                        <td>{{ $classroom['id'] }}</td>
                        <td>{{ $classroom['name'] }}</td>
                        @if(isset($classroom['new_report']))
                            @isset($reportCards[$classroom['old_report']])
                                <td>{!! $reportCards[$classroom['old_report']] !!}</td>
                            @endisset
                            <td>{!! $reportCards[$classroom['new_report']] !!}</td>
                        @endif
                        @if(isset($classroom['new_alternative_report']))
                            <td>
                                @isset($reportCards[$classroom['old_alternative_report']])
                                    {!! $reportCards[$classroom['old_alternative_report']] !!}
                                @endisset
                            </td>
                            <td>{!! $reportCards[$classroom['new_alternative_report']] !!}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        @if(Session::has('show-confirmation'))
            <div id="modal-confirmation">
            <p>Serão atualizadas <b>{{Session::get('show-confirmation')['count']}}</b> turmas</p>
                <p>Deseja continuar?</p>
            </div>
        @endif
    @endsection

    @prepend('scripts')
        <script>
            $j("#modal-confirmation").dialog({
                autoOpen: false,
                closeOnEscape: false,
                draggable: false,
                width: 560,
                modal: true,
                resizable: false,
                title: 'Confirmação',
                buttons: {
                    "Salvar": function () {
                        $j('#formcadastro').append(
                            "<input type='hidden' name='confirmation' value='1'>"
                        ).submit();
                        $j(this).dialog("close");
                    },
                    "Cancelar": function () {
                        $j(this).dialog("close");
                    }
                },
                close: function () {

                },
            });
            $j("#modal-confirmation").dialog("open");
        </script>
        <script type="text/javascript"
                src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
        <script type="text/javascript"
                src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
        <script type="text/javascript"
                src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
        <script type="text/javascript"
                src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Curso.js") }}"></script>
        <script type="text/javascript"
                src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Turma.js") }}"></script>
    @endprepend

        <div style="text-align: center">
            <button class="btn-green" type="submit">Buscar</button>
        </div>

    </form>

    <table class="table-default">
        <thead>
        <tr>
            <th>Aluno principal</th>
            <th>Aluno(s) unificado(s)</th>
            <th>Data da unificação</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse($unifications as $unification)
            <tr>
                <td>
                    <a href="{{ route('student-log-unification.show', ['unification' => $unification->id]) }}">{{ $unification->getMainName()  }}</a>
                </td>
                <td>
                    <a href="{{ route('student-log-unification.show', ['unification' => $unification->id]) }}">{{ implode(', ', $unification->getDuplicatesName()) }}</a>
                </td>
                <td>
                    <a href="{{ route('student-log-unification.show', ['unification' => $unification->id]) }}">{{ $unification->created_at->format('d/m/Y')  }}</a>
                </td>
                <td>
                    <a href="{{ route('student-log-unification.show', ['unification' => $unification->id]) }}">@if($unification->active) Ativa @else Inativa @endif</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Não foi encontrado nenhum log de unificação</td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <div class="separator"></div>

    <div style="text-align: center">
        {{ $unifications->appends(request()->except('page'))->links() }}
    </div>

    <div style="text-align: center">
        <a href="/intranet/educar_unifica_aluno.php">
            <button class="btn-green" type="button">Novo</button>
        </a>
    </div>

    </form>
@endsection

@prepend('scripts')
    <link type='text/css' rel='stylesheet' href='{{ Asset::get("/vendor/legacy/Portabilis/Assets/Plugins/Chosen/chosen.css") }}'>
    <script type='text/javascript' src='{{ Asset::get('/vendor/legacy/Portabilis/Assets/Plugins/Chosen/chosen.jquery.min.js') }}'></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend
