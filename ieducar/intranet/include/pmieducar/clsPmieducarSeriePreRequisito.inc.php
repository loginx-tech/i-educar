<?php

use iEducar\Legacy\Model;

require_once 'include/pmieducar/geral.inc.php';

class clsPmieducarSeriePreRequisito extends Model
{
    public $ref_cod_pre_requisito;
    public $ref_cod_operador;
    public $ref_cod_serie;
    public $valor;

    public function __construct($ref_cod_pre_requisito = null, $ref_cod_operador = null, $ref_cod_serie = null, $valor = null)
    {
        $db = new clsBanco();
        $this->_schema = 'pmieducar.';
        $this->_tabela = "{$this->_schema}serie_pre_requisito";

        $this->_campos_lista = $this->_todos_campos = 'ref_cod_pre_requisito, ref_cod_operador, ref_cod_serie, valor';

        if (is_numeric($ref_cod_serie)) {
            if (class_exists('clsPmieducarSerie')) {
                $tmp_obj = new clsPmieducarSerie($ref_cod_serie);
                if (method_exists($tmp_obj, 'existe')) {
                    if ($tmp_obj->existe()) {
                        $this->ref_cod_serie = $ref_cod_serie;
                    }
                } elseif (method_exists($tmp_obj, 'detalhe')) {
                    if ($tmp_obj->detalhe()) {
                        $this->ref_cod_serie = $ref_cod_serie;
                    }
                }
            } else {
                if ($db->CampoUnico("SELECT 1 FROM pmieducar.serie WHERE cod_serie = '{$ref_cod_serie}'")) {
                    $this->ref_cod_serie = $ref_cod_serie;
                }
            }
        }
        if (is_numeric($ref_cod_operador)) {
            if (class_exists('clsPmieducarOperador')) {
                $tmp_obj = new clsPmieducarOperador($ref_cod_operador);
                if (method_exists($tmp_obj, 'existe')) {
                    if ($tmp_obj->existe()) {
                        $this->ref_cod_operador = $ref_cod_operador;
                    }
                } elseif (method_exists($tmp_obj, 'detalhe')) {
                    if ($tmp_obj->detalhe()) {
                        $this->ref_cod_operador = $ref_cod_operador;
                    }
                }
            } else {
                if ($db->CampoUnico("SELECT 1 FROM pmieducar.operador WHERE cod_operador = '{$ref_cod_operador}'")) {
                    $this->ref_cod_operador = $ref_cod_operador;
                }
            }
        }
        if (is_numeric($ref_cod_pre_requisito)) {
            if (class_exists('clsPmieducarPreRequisito')) {
                $tmp_obj = new clsPmieducarPreRequisito($ref_cod_pre_requisito);
                if (method_exists($tmp_obj, 'existe')) {
                    if ($tmp_obj->existe()) {
                        $this->ref_cod_pre_requisito = $ref_cod_pre_requisito;
                    }
                } elseif (method_exists($tmp_obj, 'detalhe')) {
                    if ($tmp_obj->detalhe()) {
                        $this->ref_cod_pre_requisito = $ref_cod_pre_requisito;
                    }
                }
            } else {
                if ($db->CampoUnico("SELECT 1 FROM pmieducar.pre_requisito WHERE cod_pre_requisito = '{$ref_cod_pre_requisito}'")) {
                    $this->ref_cod_pre_requisito = $ref_cod_pre_requisito;
                }
            }
        }

        if (is_string($valor)) {
            $this->valor = $valor;
        }
    }

    /**
     * Cria um novo registro
     *
     * @return bool
     */
    public function cadastra()
    {
        if (is_numeric($this->ref_cod_pre_requisito) && is_numeric($this->ref_cod_operador) && is_numeric($this->ref_cod_serie)) {
            $db = new clsBanco();

            $campos = '';
            $valores = '';
            $gruda = '';

            if (is_numeric($this->ref_cod_pre_requisito)) {
                $campos .= "{$gruda}ref_cod_pre_requisito";
                $valores .= "{$gruda}'{$this->ref_cod_pre_requisito}'";
                $gruda = ', ';
            }
            if (is_numeric($this->ref_cod_operador)) {
                $campos .= "{$gruda}ref_cod_operador";
                $valores .= "{$gruda}'{$this->ref_cod_operador}'";
                $gruda = ', ';
            }
            if (is_numeric($this->ref_cod_serie)) {
                $campos .= "{$gruda}ref_cod_serie";
                $valores .= "{$gruda}'{$this->ref_cod_serie}'";
                $gruda = ', ';
            }
            if (is_string($this->valor)) {
                $campos .= "{$gruda}valor";
                $valores .= "{$gruda}'{$this->valor}'";
                $gruda = ', ';
            }

            $db->Consulta("INSERT INTO {$this->_tabela} ( $campos ) VALUES( $valores )");

            return true;
        }

        return false;
    }

    /**
     * Edita os dados de um registro
     *
     * @return bool
     */
    public function edita()
    {
        if (is_numeric($this->ref_cod_pre_requisito) && is_numeric($this->ref_cod_operador) && is_numeric($this->ref_cod_serie)) {
            $db = new clsBanco();
            $set = '';

            if (is_string($this->valor)) {
                $set .= "{$gruda}valor = '{$this->valor}'";
                $gruda = ', ';
            }

            if ($set) {
                $db->Consulta("UPDATE {$this->_tabela} SET $set WHERE ref_cod_pre_requisito = '{$this->ref_cod_pre_requisito}' AND ref_cod_operador = '{$this->ref_cod_operador}' AND ref_cod_serie = '{$this->ref_cod_serie}'");

                return true;
            }
        }

        return false;
    }

    /**
     * Retorna uma lista filtrados de acordo com os parametros
     *
     * @return array
     */
    public function lista($int_ref_cod_pre_requisito = null, $int_ref_cod_operador = null, $int_ref_cod_serie = null, $str_valor = null)
    {
        $sql = "SELECT {$this->_campos_lista} FROM {$this->_tabela}";
        $filtros = '';

        $whereAnd = ' WHERE ';

        if (is_numeric($int_ref_cod_pre_requisito)) {
            $filtros .= "{$whereAnd} ref_cod_pre_requisito = '{$int_ref_cod_pre_requisito}'";
            $whereAnd = ' AND ';
        }
        if (is_numeric($int_ref_cod_operador)) {
            $filtros .= "{$whereAnd} ref_cod_operador = '{$int_ref_cod_operador}'";
            $whereAnd = ' AND ';
        }
        if (is_numeric($int_ref_cod_serie)) {
            $filtros .= "{$whereAnd} ref_cod_serie = '{$int_ref_cod_serie}'";
            $whereAnd = ' AND ';
        }
        if (is_string($str_valor)) {
            $filtros .= "{$whereAnd} valor LIKE '%{$str_valor}%'";
            $whereAnd = ' AND ';
        }

        $db = new clsBanco();
        $countCampos = count(explode(',', $this->_campos_lista));
        $resultado = [];

        $sql .= $filtros . $this->getOrderby() . $this->getLimite();

        $this->_total = $db->CampoUnico("SELECT COUNT(0) FROM {$this->_tabela} {$filtros}");

        $db->Consulta($sql);

        if ($countCampos > 1) {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();

                $tupla['_total'] = $this->_total;
                $resultado[] = $tupla;
            }
        } else {
            while ($db->ProximoRegistro()) {
                $tupla = $db->Tupla();
                $resultado[] = $tupla[$this->_campos_lista];
            }
        }
        if (count($resultado)) {
            return $resultado;
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro
     *
     * @return array
     */
    public function detalhe()
    {
        if (is_numeric($this->ref_cod_pre_requisito) && is_numeric($this->ref_cod_operador) && is_numeric($this->ref_cod_serie)) {
            $db = new clsBanco();
            $db->Consulta("SELECT {$this->_todos_campos} FROM {$this->_tabela} WHERE ref_cod_pre_requisito = '{$this->ref_cod_pre_requisito}' AND ref_cod_operador = '{$this->ref_cod_operador}' AND ref_cod_serie = '{$this->ref_cod_serie}'");
            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }

    /**
     * Retorna um array com os dados de um registro
     *
     * @return array
     */
    public function existe()
    {
        if (is_numeric($this->ref_cod_pre_requisito) && is_numeric($this->ref_cod_operador) && is_numeric($this->ref_cod_serie)) {
            $db = new clsBanco();
            $db->Consulta("SELECT 1 FROM {$this->_tabela} WHERE ref_cod_pre_requisito = '{$this->ref_cod_pre_requisito}' AND ref_cod_operador = '{$this->ref_cod_operador}' AND ref_cod_serie = '{$this->ref_cod_serie}'");
            $db->ProximoRegistro();

            return $db->Tupla();
        }

        return false;
    }

    /**
     * Exclui um registro
     *
     * @return bool
     */
    public function excluir()
    {
        if (is_numeric($this->ref_cod_pre_requisito) && is_numeric($this->ref_cod_operador) && is_numeric($this->ref_cod_serie)) {
            $db = new clsBanco();
            $db->Consulta("DELETE FROM {$this->_tabela} WHERE ref_cod_pre_requisito = '{$this->ref_cod_pre_requisito}' AND ref_cod_operador = '{$this->ref_cod_operador}' AND ref_cod_serie = '{$this->ref_cod_serie}'");

            return true;
        }

        return false;
    }
}
