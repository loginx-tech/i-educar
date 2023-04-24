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
                        <td class="formdktd" colspan="2" height="24"><b>Cadastro SED</b></td>
                    </tr>
                    <tr>
                        @if ($action == 'create')
                            <td class="formmdtd" colspan="2" valign="top">
                                <span class="form">
                                    Esta sala não possui vinculo ao SED, caso já tenha sido realizado o cadastro na
                                    plataforma,
                                    vincule a sala com o seu código de turma. <br>
                                    Caso a sala ainda não tenha sido cadastrada no SED, clique em cadastrar nova sala.
                                </span>
                            </td>
                        @else
                            <td class="formmdtd" colspan="2" valign="top">
                                <span class="form">
                                    Esta sala já possui um vinculo com o SED, caso deseje alterar o código da turma, clique alterar codigo de vinculo.
                                    (Esta ação removera o vinculo atual e criara um novo vinculo com o código informado,
                                    tenha certeza que o código informado, é o código da turma no SED)
                                </span>
                            </td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </form>

        <div class="separator" style="margin-top: 20px; margin-bottom: 20px;"></div>

    </form>

        <form id="formcadastro" action="{{ route('sed.class.store-code', $codClass) }}" method="post">
            @csrf
            <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
                <tbody>
                    <tr>
                        <td class="formdktd" colspan="2" height="24"><b>Vínculo de Turma</b></td>
                    </tr>

                    <tr>
                        <td class="formmdtd" valign="top">
                            <span class="form">Código de cadastro SED *</span>
                        </td>

                        @if ($action == 'create')
                            <td class="formmdtd" valign="top">
                                <span class="form">
                                    <input class="obrigatorio @error('inCodSed') is-invalid @enderror"
                                        type="text" name="inCodSed" id="inCodSed" required
                                        value="{{ old('inCodSed') }}"
                                        size="50" maxlength="255">
                                </span>
                            </td>
                        @else
                            <td class="formmdtd" valign="top">
                                <span class="form">
                                    <input class="obrigatorio @error('inCodSed') is-invalid @enderror"
                                        type="text" name="inCodSed" id="inCodSed" required
                                        value="{{ old('inCodSed') ? old('inCodSed') : $classSed->cod_sed }}"
                                        size="50" maxlength="255">
                                </span>
                            </td>
                        @endif
                    </tr>

                </tbody>
            </table>


            <div style="text-align: center;">
                <button class="btn-green" type="submit">Vincular código</button>
            </div>

        </form>

    <div class="separator" style="margin-bottom: 30px;"></div>

    @if ($action == 'create')
        <div style="text-align: center; margin-top: 10px;">
            <a href="{{ route('sed.class.create', $codClass) }}" class="btn-green">Cadastrar nova sala no SED</a>
        </div>
    @else
        <div style="text-align: center; margin-top: 10px;">
            <a href="{{ route('sed.class.edit', $codClass) }}" class="btn-green">Editar cadastro no sed</a>
        </div>
    @endif


@endsection

@prepend('scripts')
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/Portabilis/Assets/Javascripts/ClientApi.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/DynamicInput.js") }}"></script>
    <script type="text/javascript"
            src="{{ Asset::get("/vendor/legacy/DynamicInput/Assets/Javascripts/Escola.js") }}"></script>
@endprepend
