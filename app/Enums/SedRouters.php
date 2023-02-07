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

    /*-- Escola -------------------------------------------------------------------*/

    // Obtem as escolas pela diretoria e município
    case GET_ESCOLAS  = '/DadosBasicos/EscolasPorMunicipio';
}
