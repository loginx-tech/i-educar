<?php

namespace App\Services\Sed\Alunos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class StoreTransferenciaService extends SedAuthService
{
    /**
     * Transferencia de aluno
     *
     * Esse método tem como finalidade a criação de inscrições para transferência de alunos (inscrição
     * transferência, intenção transferência ou deslocamento) entre escolas da rede pública, atendendo os
     * critérios do processo da matricula antecipada.
     *
     */
    public function __invoke($data)
    {
        $response = parent::post(
            SedRouters::STORE_TRANSFERENCIA->value,
            [
                'inAluno'       => [
                    'inNumRA'         => isset($data['inNumRA']) ? $data['inNumRA'] : null, // Obrigarório
                    'inDigitoRA'      => isset($data['inDigitoRA']) ? $data['inDigitoRA'] : null,
                    'inSiglaUFRA'     => isset($data['inSiglaUFRA']) ? $data['inSiglaUFRA'] : null, // Obrigarório
                ],
                'inTransferencia'   => [
                    'inAnoLetivo' => isset($data['inAnoLetivo']) ? $data['inAnoLetivo'] : null, // Obrigarório
                    'inCodEscola' => isset($data['inCodEscola']) ? $data['inCodEscola'] : null, // Obrigarório
                    'inFase'            => isset($data['inFase']) ? $data['inFase'] : null, // Obrigarório

                    'inInteresseIntegral'  => isset($data['inInteresseIntegral']) ? $data['inInteresseIntegral'] : null,
                    'inInteresseEspanhol'  => isset($data['inInteresseEspanhol']) ? $data['inInteresseEspanhol'] : null,
                    'inNecesAtendNoturno'  => isset($data['inNecesAtendNoturno']) ? $data['inNecesAtendNoturno'] : null,
                    'inInteresseIntegral'  => isset($data['inInteresseIntegral']) ? $data['inInteresseIntegral'] : null,

                    'inNumClasseMatriculaAtual'  => isset($data['inNumClasseMatriculaAtual']) ? $data['inNumClasseMatriculaAtual'] : null, // Obrigarório
                    'inMotivo'                   => isset($data['inMotivo']) ? $data['inMotivo'] : null, // Obrigarório

                ],
                'inNivelEnsino' => [
                    'inCodTipoEnsino' => isset($data['inCodTipoEnsino']) ? $data['inCodTipoEnsino'] : null, // Obrigarório
                    'inCodSerieAno'   => isset($data['inCodSerieAno']) ? $data['inCodSerieAno'] : null, // Obrigarório
                ]
            ]
        );

        /* Details

            inFase - 0 – Inscrição de Alunos por Transferência
                     8 – Inscrição de Alunos por Deslocamento
                     9 – Inscrição por Intenção de Transferência

            inInteresseIntegral - Indica interesse em uma futura matricula no turno integral. Preencher com “1” caso haja interesse.
            inInteresseEspanhol - Indica interesse em uma futura matrícula com o curso de espanhol (Exclusivo para a rede Estadual).
                                  Preencher com “1” caso haja interesse.
            inNecesAtendNoturno - Indica necessidade em uma futura matrícula no período noturno (Exclusivo para a rede Estadual).
                                  Preencher com “1” caso haja interesse.

            inMotivo - Tem opções para cada inFase, e ensino fundamental e médio tem opções diferentes.

                        Inscrição de Alunos por Transferência --

                        ** Ensino e EJA Fundamental
                            1 – Mudança de Residência
                            2 – Proximidade local de trabalho dos pais
                            3 - Endereço dos familiares
                        ** Ensino e EJA Médio
                            1 – Mudança de Residência
                            2 – Proximidade local trabalho e/ou horário trabalho aluno

                        Inscrição de Alunos por Deslocamento

                        ** Ensino e EJA Fundamental
                            1 – Mudança de Residência
                            2 – Proximidade local de trabalho dos pais
                            3 - Endereço dos familiares
                        ** Ensino e EJA Médio
                            1 – Mudança de Residência
                            2 – Proximidade local trabalho e/ou horário trabalho aluno
                            4 – Interesse do aluno

                        Inscrição por Intenção de Transferência
                            4 – Interesse do aluno

        */

        return $response;
    }
}
