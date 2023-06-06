<?php

namespace App\Enums;

enum SedRouters: string
{
    /*-- Autenticação -------------------------------------------------------------*/
    case VALIDA_USUARIO = '/Usuario/ValidarUsuario';

    /*-- Aluno --------------------------------------------------------------------*/

    // Cria os dados do aluno no SED e retorna o RA
    case STORE_ALUNO = '/Aluno/FichaAluno';

    // Mostra a ficha do aluno no SED
    case GET_ALUNO = '/Aluno/ExibirFichaAluno';

    // Matricula de continuidade (rematricula), efetivação de inscrições e definições (matricula antecipada)
    case STORE_MATRICULA = '/Matricula/MatricularAluno';

    // Remanejamento
    case STORE_REMANEJAMENTO = '/Matricula/RemanejarMatricula';

    // Transferência
    case STORE_TRANSFERENCIA = '/Inscricao/Transferencia';

    /*-- Escola -------------------------------------------------------------------*/

    // Obtem as escolas pela diretoria e município
    case GET_ESCOLAS  = '/DadosBasicos/EscolasPorMunicipio';

    // Obtem os dados da escola
    case GET_ESCOLA = '/DadosBasicos/Escolas';

    //obtem as unidades
    case GET_UNIDADES = '/DadosBasicos/UnidadesPorEscola';

    /*-- Sala ---------------------------------------------------------------------*/

    // Obtem as salas da escola
    case GET_SALAS = '/RelacaoAlunosClasse/RelacaoClasses';

    // Obtem os dados da sala
    case GET_SALA = '/TurmaClasse/ConsultaTurmaClasse';

    // Update da sala
    case UPDATE_SALA = '/TurmaClasse/ManutencaoTurmaClasse';

    // Cria a sala
    case STORE_SALA = '/TurmaClasse/IncluirTurmaClasse';

    // Formação da turma, exibe a lista de alunos
    case FORMACAO_TURMA = '/RelacaoAlunosClasse/FormacaoClasse';

    /*-- Dados Basicos ------------------------------------------------------------*/

    case TIPOS_CLASSE = '/DadosBasicos/TipoClasse';

    case TIPOS_ENSINO = '/DadosBasicos/TipoEnsino';
}
