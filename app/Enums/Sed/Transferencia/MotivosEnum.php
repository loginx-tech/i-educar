<?php

namespace App\Enums\Sed\Transferencia;

enum MotivosEnum: int
{
    // Retorna um codigo caso queria manupular o valor fora das funções do enum Ex. 000

    // Primeiro digito: 100 ou 0 - Inscrição de Alunos por Transferência, 8 - Inscrição de Alunos por Deslocamento, 9 - Inscrição por Intenção de Transferência
    // Segundo digito: 0 - Ensino Fundamental, 1 - Ensino Médio
    // Terceiro digito: O proprio codigo do motivo vindo do SED
    // Se houver apenas 2 digitos ele é tanto para medio quanto fundamental entao não conta o digito dois.

    case TRANSFERENCIA_FUND_MUDANCA    = 001;
    case TRANSFERENCIA_FUND_TRABALHO   = 002;
    case TRANSFERENCIA_FUND_FAMILIA    = 003;

    case TRANSFERENCIA_MEDIO_MUDANCA   = 011;
    case TRANSFERENCIA_MEDIO_TRABALHO  = 012;

    case DESLOCAMENTO_FUND_MUDANCA     = 801;
    case DESLOCAMENTO_FUND_TRABALHO    = 802;
    case DESLOCAMENTO_FUND_FAMILIA     = 803;

    case DESLOCAMENTO_MEDIO_MUDANCA    = 811;
    case DESLOCAMENTO_MEDIO_TRABALHO   = 812;
    case DESLOCAMENTO_MEDIO_INTERESSE  = 814;

    case INTENCAO_INTERESSE            = 94;

    public function toString(): string
    {
        switch ($this->value) {
            case self::TRANSFERENCIA_FUND_MUDANCA->value:   return 'Mudança de Residência';
                // no break
            case self::TRANSFERENCIA_FUND_TRABALHO->value:  return 'Proximidade local de trabalho dos pais';
            case self::TRANSFERENCIA_FUND_FAMILIA->value:   return 'Endereço dos familiares';

            case self::TRANSFERENCIA_MEDIO_MUDANCA->value:  return 'Mudança de Residência';
            case self::TRANSFERENCIA_MEDIO_TRABALHO->value: return 'Proximidade local trabalho e/ou horário trabalho aluno';

            case self::DESLOCAMENTO_FUND_MUDANCA->value:    return 'Mudança de Residência';
            case self::DESLOCAMENTO_FUND_TRABALHO->value:   return 'Proximidade local de trabalho dos pais';
            case self::DESLOCAMENTO_FUND_FAMILIA->value:    return 'Endereço dos familiares';

            case self::DESLOCAMENTO_MEDIO_MUDANCA->value:   return 'Mudança de Residência';
            case self::DESLOCAMENTO_MEDIO_TRABALHO->value:  return 'Proximidade local trabalho e/ou horário trabalho aluno';
            case self::DESLOCAMENTO_MEDIO_INTERESSE->value: return 'Interesse do aluno';

            case self::INTENCAO_INTERESSE->value:           return 'Interesse do aluno';
        }
    }

    public function getCod(): int
    {
        switch ($this->value) {
            case self::TRANSFERENCIA_FUND_MUDANCA->value:   return 1;
            case self::TRANSFERENCIA_FUND_TRABALHO->value:  return 2;
            case self::TRANSFERENCIA_FUND_FAMILIA->value:   return 3;

            case self::TRANSFERENCIA_MEDIO_MUDANCA->value:  return 1;
            case self::TRANSFERENCIA_MEDIO_TRABALHO->value: return 2;

            case self::DESLOCAMENTO_FUND_MUDANCA->value:    return 1;
            case self::DESLOCAMENTO_FUND_TRABALHO->value:   return 2;
            case self::DESLOCAMENTO_FUND_FAMILIA->value:    return 3;

            case self::DESLOCAMENTO_MEDIO_MUDANCA->value:   return 1;
            case self::DESLOCAMENTO_MEDIO_TRABALHO->value:  return 2;
            case self::DESLOCAMENTO_MEDIO_INTERESSE->value: return 4;

            case self::INTENCAO_INTERESSE->value:           return 4;
        }
    }

    public function getEnsino(): string
    {
        // verificando se o segundo digito é 0
        if (substr($this->value, 1, 1) == 0) {
            return 'Fundamental';
        } else {
            return 'Médio';
        }
    }

    public function getEnsinoCod(): int
    {
        // verificando se o segundo digito é 0
        if (substr($this->value, 1, 1) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getTipo(): string
    {
        // verificando se o primeiro digito é 1
        if (substr($this->value, 0, 1) == 1) {
            return 'Transferência';
        } elseif (substr($this->value, 0, 1) == 8) {
            return 'Deslocamento';
        } else {
            return 'Intenção';
        }
    }

    public function getTipoCod(): int
    {
        // verificando se o primeiro digito é 1
        if (substr($this->value, 0, 1) == 1) {
            return 0;
        } elseif (substr($this->value, 0, 1) == 8) {
            return 8;
        } else {
            return 9;
        }
    }

    /**
     *  Retorna as opções para a inFase de transferencia
     *
     *  @param string $ensino - 0 para fundamental e 1 para medio
     *
     *  @return array
     */
    public static function casesTransferencia($ensino): array
    {
        if ($ensino == 0 || $ensino == 'Fundamental') {
            return [
                self::TRANSFERENCIA_FUND_MUDANCA,
                self::TRANSFERENCIA_FUND_TRABALHO,
                self::TRANSFERENCIA_FUND_FAMILIA,
            ];
        } else { // Case Medio
            return [
                self::TRANSFERENCIA_MEDIO_MUDANCA,
                self::TRANSFERENCIA_MEDIO_TRABALHO,
            ];
        }
    }

    /**
     *  Retorna as opções para a inFase de deslocamento
     *
     *  @param string $ensino - 0 para fundamental e 1 para medio
     *
     *  @return array
     */
    public static function casesDescolamento($ensino): array
    {
        if ($ensino == 0 || $ensino == 'Fundamental') {
            return [
                self::DESLOCAMENTO_FUND_MUDANCA,
                self::DESLOCAMENTO_FUND_TRABALHO,
                self::DESLOCAMENTO_FUND_FAMILIA,
            ];
        } else { // Case Medio
            return [
                self::DESLOCAMENTO_MEDIO_MUDANCA,
                self::DESLOCAMENTO_MEDIO_TRABALHO,
                self::DESLOCAMENTO_MEDIO_INTERESSE,
            ];
        }
    }

    /**
     *  Retorna as opções para a inFase de intenção
     *
     *  @param string $ensino - 0 para fundamental e 1 para medio
     *
     *  @return array
     */
    public static function casesIntencao($ensino): array
    {
        // Nessas opções não importa o ensino
        return [
            self::INTENCAO_INTERESSE,
        ];
    }
}
