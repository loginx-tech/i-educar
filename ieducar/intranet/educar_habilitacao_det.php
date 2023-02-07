<?php

use App\Models\LegacyQualification;

return new class extends clsDetalhe {
    public $titulo;
    public $cod_habilitacao;
    public $ref_usuario_exc;
    public $ref_usuario_cad;
    public $nm_tipo;
    public $descricao;
    public $data_cadastro;
    public $data_exclusao;
    public $ativo;
    public $ref_cod_instituicao;

    public function Gerar()
    {
        $this->titulo = 'Habilitacao - Detalhe';

        $this->cod_habilitacao=$_GET['cod_habilitacao'];

        $registro = LegacyQualification::find($this->cod_habilitacao)?->getAttributes();

        if (! $registro) {
            $this->simpleRedirect('educar_habilitacao_lst.php');
        }
        if ($registro['ref_cod_instituicao']) {
            $obj_cod_instituicao = new clsPmieducarInstituicao($registro['ref_cod_instituicao']);
            $obj_cod_instituicao_det = $obj_cod_instituicao->detalhe();
            $registro['ref_cod_instituicao'] = $obj_cod_instituicao_det['nm_instituicao'];

            $this->addDetalhe([ 'Instituição', "{$registro['ref_cod_instituicao']}"]);
        }
        if ($registro['nm_tipo']) {
            $this->addDetalhe([ 'Habilitação', "{$registro['nm_tipo']}"]);
        }
        if ($registro['descricao']) {
            $this->addDetalhe([ 'Descrição', "{$registro['descricao']}"]);
        }

        $obj_permissao = new clsPermissoes();
        if ($obj_permissao->permissao_cadastra(int_processo_ap: 573, int_idpes_usuario: $this->pessoa_logada, int_soma_nivel_acesso: 3)) {
            $this->url_novo = 'educar_habilitacao_cad.php';
            $this->url_editar = "educar_habilitacao_cad.php?cod_habilitacao={$registro['cod_habilitacao']}";
        }
        $this->url_cancelar = 'educar_habilitacao_lst.php';
        $this->largura = '100%';

        $this->breadcrumb(currentPage: 'Detalhe da habilitação', breadcrumbs: [
            url('intranet/educar_index.php') => 'Escola',
        ]);
    }

    public function Formular()
    {
        $this->title = 'Habilitação';
        $this->processoAp = '573';
    }
};
