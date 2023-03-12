@extends('layout.default-sed')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ Asset::get('css/ieducar.css') }}"/>
@endpush

@section('breadcrumb', 'Escolas')
@section('breadcrumb_url', url('/intranet/educar_escola_lst.php'))

@section('content')

<table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
    <tbody>
    <tr>
        <td class="formdktd" colspan="2" height="24"><b>Ficha de Cadastro no SED</b></td>
    </tr>

    @section('content')
    <form id="formcadastro" action="" method="post">
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Dados Básicos</b></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Nome</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outDescNomeEscola ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Código (CIEE)</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{  $escola->outCodEscola ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Descrição da diretoria</span></td>
                    <td class="formmdtd" valign="top"><span class="form"></span>{{ $escola->outDescNomeDiretoria ? "$escola->outDescNomeDiretoria - $escola->outCodDiretoria" : '' }}</td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Descrição da rede de ensino</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outNomeRedeEnsino ? "$escola->outNomeRedeEnsino - $escola->outCodRedeEnsino" : '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Descrição do distrito</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outNomeDistrito ? "$escola->outNomeDistrito - $escola->outCodDistrito" : '' }}</span></td>
                </tr>
            </tbody>
        </table>
    </form>

    <div class="separator"></div>

    <form id="formcadastro" action="" method="post">
        <table class="tablecadastro" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="2" height="24"><b>Endereço</b></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">CEP</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outCEP ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form">Tipo de logradouro</span></td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outTipoLogradouro ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Endereço</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outDescEndereco ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Número</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outNumero ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Bairro</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outDescBairro ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Descrição completa</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outDescComplemento ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Município</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outDescMunicipio ? "$escola->outDescMunicipio - $escola->outCodMunicipio" : '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Latitude geográfica</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outLatitude ?? '' }}</span></td>
                </tr>
                <tr>
                    <td class="formmdtd" valign="top"><span class="form"></span>Longitude geográfica</td>
                    <td class="formmdtd" valign="top"><span class="form">{{ $escola->outLongitude ?? '' }}</span></td>
                </tr>
            </tbody>
        </table>
    </form>

    <div class="separator"></div>

    <form id="formcadastro" action="" method="post">
        <table class="tablecadastro p" width="100%" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td class="formdktd" colspan="3" height="24"><b>Unidades escolares</b></td>
                </tr>

                @if($escola->outUnidades)
                    <tr>
                        <td class="formmdtd bold" valign="top"><span class="form"><b>Nome / Descrição</b></span></td>
                        <td class="formmdtd bold" valign="top"><span class="form"><b>Código</b></span></td>
                        <td class="formmdtd bold" valign="top"><span class="form"><b>Telefone</b></span></td>
                    </tr>
                @endif

                @forelse ($escola->outUnidades as $unidade)
                    <tr>
                        <td class="formmdtd" valign="top"><span class="form">{{ $unidade->outDescNomeUnidade ?? '' }}</span></td>
                        <td class="formmdtd" valign="top"><span class="form">{{ $unidade->outCodUnidade ?? '' }}</span></td>
                        <td class="formmdtd" valign="top"><span class="form">{{ $unidade->outTelefone ? "($unidade->outDDD) $unidade->outTelefone" : '' }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td class="formdktd" colspan="3" valign="top"><span class="form">Não há unidades cadastradas</span></td>
                    </tr>
                @endforelse

            </tbody>
        </table>
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
