<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;

return new class extends clsCadastro {
    public $pessoa_logada;
    public $cod_calendario_anotacao;
    public $ref_usuario_exc;
    public $ref_usuario_cad;
    public $nm_anotacao;
    public $descricao;
    public $data_cadastro;
    public $data_exclusao;
    public $ativo;
    public $dia;
    public $mes;
    public $ano;
    public $ref_ref_cod_calendario_ano_letivo;

    public function Inicializar()
    {
        $retorno = 'Novo';

        $this->cod_calendario_anotacao=$_GET['cod_calendario_anotacao'];
        $this->dia=$_GET['dia'];
        $this->mes=$_GET['mes'];
        $this->ano=$_GET['ano'];
        $this->ref_ref_cod_calendario_ano_letivo=$_GET['ref_cod_calendario_ano_letivo'];

        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(int_processo_ap: 620, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 7, str_pagina_redirecionar: 'educar_calendario_anotacao_lst.php');
        if (!is_numeric(value: $this->ref_ref_cod_calendario_ano_letivo) || !is_numeric(value: $this->dia) || !is_numeric(value: $this->mes)) {
            throw new HttpResponseException(
                response: new RedirectResponse(url: 'educar_calendario_ano_letivo_lst.php')
            );
        }
        if (is_numeric(value: $this->cod_calendario_anotacao)) {
            $obj = new clsPmieducarCalendarioAnotacao(cod_calendario_anotacao: $this->cod_calendario_anotacao);
            $registro  = $obj->detalhe();
            if ($registro) {
                foreach ($registro as $campo => $val) {  // passa todos os valores obtidos no registro para atributos do objeto
                    $this->$campo = $val;
                }
                $this->data_cadastro = dataFromPgToBr(data_original: $this->data_cadastro);
                $this->data_exclusao = dataFromPgToBr(data_original: $this->data_exclusao);

                $obj_permissoes = new clsPermissoes();
                if ($obj_permissoes->permissao_excluir(int_processo_ap: 620, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 7)) {
                    $this->fexcluir = true;
                }

                $retorno = 'Editar';
            }
        }
        $this->url_cancelar =  "educar_calendario_anotacao_lst.php?dia={$this->dia}&mes={$this->mes}&ano={$this->ano}&ref_cod_calendario_ano_letivo={$this->ref_ref_cod_calendario_ano_letivo}";
        $this->nome_url_cancelar = 'Cancelar';

        return $retorno;
    }

    public function Gerar()
    {
        $this->campoRotulo(nome: 'info', campo: '-', valor: "Anotações Calendário do dia <b>{$this->dia}/{$this->mes}/{$this->ano}</b>");
        $this->campoOculto(nome: 'cod_calendario_anotacao', valor: $this->cod_calendario_anotacao);

        $this->campoOculto(nome: 'dia', valor: $this->dia);
        $this->campoOculto(nome: 'mes', valor: $this->mes);
        $this->campoOculto(nome: 'ano', valor: $this->ano);
        $this->campoOculto(nome: 'ref_ref_cod_calendario_ano_letivo', valor: $this->ref_ref_cod_calendario_ano_letivo);

        $this->campoTexto(nome: 'nm_anotacao', campo: 'Anotação', valor: $this->nm_anotacao, tamanhovisivel: 30, tamanhomaximo: 255, obrigatorio: true);
        $this->campoMemo(nome: 'descricao', campo: 'Descrição', valor: $this->descricao, colunas: 60, linhas: 5, obrigatorio: false);

    }

    public function Novo()
    {
        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(int_processo_ap: 620, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 7, str_pagina_redirecionar: 'educar_calendario_anotacao_lst.php');

        $obj_dia = new clsPmieducarCalendarioDia(ref_cod_calendario_ano_letivo: $this->ref_ref_cod_calendario_ano_letivo, mes: $this->mes, dia: $this->dia);
        if (!$obj_dia->existe()) {
            $obj_dia = new clsPmieducarCalendarioDia(ref_cod_calendario_ano_letivo: $this->ref_ref_cod_calendario_ano_letivo, mes: $this->mes, dia: $this->dia, ref_usuario_exc: null, ref_usuario_cad: $this->pessoa_logada, ref_cod_calendario_dia_motivo: null, descricao: null, data_cadastro: null, data_exclusao: null, ativo: 1);
            $ref_cod_dia_letivo = $obj_dia->cadastra();
            if (!$ref_cod_dia_letivo) {
                return false;
            }
        }
        $obj = new clsPmieducarCalendarioAnotacao(cod_calendario_anotacao: $this->cod_calendario_anotacao, ref_usuario_exc: $this->pessoa_logada, ref_usuario_cad: $this->pessoa_logada, nm_anotacao: $this->nm_anotacao, descricao: $this->descricao, data_cadastro: $this->data_cadastro, data_exclusao: $this->data_exclusao, ativo: $this->ativo);
        $this->cod_calendario_anotacao = $cadastrou = $obj->cadastra();
        if ($cadastrou) {
            $obj_anotacao_dia = new clsPmieducarCalendarioDiaAnotacao(ref_dia: $this->dia, ref_mes: $this->mes, ref_ref_cod_calendario_ano_letivo: $this->ref_ref_cod_calendario_ano_letivo, ref_cod_calendario_anotacao: $cadastrou);
            $cadastrado = $obj_anotacao_dia->cadastra();
            if ($cadastrado) {
                $this->mensagem .= 'Cadastro efetuado com sucesso.<br>';
                $this->simpleRedirect(url: "educar_calendario_anotacao_lst.php?dia={$this->dia}&mes={$this->mes}&ano={$this->ano}&ref_cod_calendario_ano_letivo={$this->ref_ref_cod_calendario_ano_letivo}");
            }

            return false;
        }
        $this->mensagem = 'Cadastro não realizado.<br>';

        return false;
    }

    public function Editar()
    {
        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_cadastra(int_processo_ap: 620, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 7, str_pagina_redirecionar: 'educar_calendario_anotacao_lst.php');

        $obj = new clsPmieducarCalendarioAnotacao(cod_calendario_anotacao: $this->cod_calendario_anotacao, ref_usuario_exc: $this->pessoa_logada, ref_usuario_cad: $this->pessoa_logada, nm_anotacao: $this->nm_anotacao, descricao: $this->descricao, data_cadastro: $this->data_cadastro, data_exclusao: $this->data_exclusao, ativo: $this->ativo);
        $editou = $obj->edita();
        if ($editou) {
            $this->mensagem .= 'Edição efetuada com sucesso.<br>';
            throw new HttpResponseException(
                response: new RedirectResponse(url: "educar_calendario_anotacao_lst.php?dia={$this->dia}&mes={$this->mes}&ano={$this->ano}&ref_cod_calendario_ano_letivo={$this->ref_cod_calendario_ano_letivo}")
            );
        }

        $this->mensagem = 'Edição não realizada.<br>';

        return false;
    }

    public function Excluir()
    {
        $obj_permissoes = new clsPermissoes();
        $obj_permissoes->permissao_excluir(int_processo_ap: 620, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 7, str_pagina_redirecionar: 'educar_calendario_anotacao_lst.php');

        $obj = new clsPmieducarCalendarioAnotacao(cod_calendario_anotacao: $this->cod_calendario_anotacao, ref_usuario_exc: $this->pessoa_logada, ref_usuario_cad: $this->pessoa_logada, nm_anotacao: $this->nm_anotacao, descricao: $this->descricao, data_cadastro: $this->data_cadastro, data_exclusao: $this->data_exclusao, ativo: 0);
        $excluiu = $obj->excluir();
        if ($excluiu) {
            $this->mensagem .= 'Exclusão efetuada com sucesso.<br>';
            throw new HttpResponseException(
                response: new RedirectResponse(url: "educar_calendario_anotacao_lst.php?dia={$this->dia}&mes={$this->mes}&ano={$this->ano}&ref_cod_calendario_ano_letivo={$this->ref_ref_cod_calendario_ano_letivo}")
            );
        }

        $this->mensagem = 'Exclusão não realizada.<br>';

        return false;
    }

    public function Formular()
    {
        $this->title = 'Calendario Anotacao';
        $this->processoAp = '620';
    }
};
