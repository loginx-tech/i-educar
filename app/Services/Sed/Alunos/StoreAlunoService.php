<?php

namespace App\Services\Sed\Alunos;

use App\Enums\SedRouters;
use App\Services\Sed\AuthService as SedAuthService;
use Illuminate\Support\Facades\{DB, Http};

class StoreAlunoService extends SedAuthService
{
    /**
     * Cria a ficha do aluno no SED, retorna o RA
     *
     */
    public function __invoke($aluno)
    {
        $response = parent::post(
            SedRouters::STORE_ALUNO->value,
            [
                'inDadosPessoais' => [
                    'inNomeAluno'                      => $aluno->inNomeAluno ? $aluno->inNomeAluno : null,
                    'inNomeMae'                        => $aluno->inNomeMae ? $aluno->inNomeMae : null,
                    'inNomePai'                        => $aluno->inNomePai ? $aluno->inNomePai : null,
                    'inNomeSocial'                     => $aluno->inNomeSocial ? $aluno->inNomeSocial : null,
                    'inNomeAfetivo'                    => $aluno->inNomeAfetivo ? $aluno->inNomeAfetivo : null,
                    'inDataNascimento'                 => $aluno->inDataNascimento ? $aluno->inDataNascimento : null,
                    'inCorRaca'                        => $aluno->inCorRaca ? $aluno->inCorRaca : null,
                    'inSexo'                           => $aluno->inSexo ? $aluno->inSexo : null,
                    'inBolsaFamilia'                   => $aluno->inBolsaFamilia ? $aluno->inBolsaFamilia : null,
                    'inQuilombola'                     => $aluno->inQuilombola ? $aluno->inQuilombola : null,
                    'inPossuiInternet'                 => $aluno->inPossuiInternet ? $aluno->inPossuiInternet : null,
                    'inPossuiNotebookSmartphoneTablet' => $aluno->inPossuiNotebookSmartphoneTablet ? $aluno->inPossuiNotebookSmartphoneTablet : null,
                    'inTipoSanguineo'                  => $aluno->inTipoSanguineo ? $aluno->inTipoSanguineo : null,
                    'inDoadorOrgaos'                   => $aluno->inDoadorOrgaos ? $aluno->inDoadorOrgaos : null,
                    'inNumeroCNS'                      => $aluno->inNumeroCNS ? $aluno->inNumeroCNS : null,
                    'inEmail'                          => $aluno->inEmail ? $aluno->inEmail : null,
                    'inNacionalidade'                  => $aluno->inNacionalidade ? $aluno->inNacionalidade : null,
                    'inNomeMunNascto'                  => $aluno->inNomeMunNascto ? $aluno->inNomeMunNascto : null,
                    'inUFMunNascto'                    => $aluno->inUFMunNascto ? $aluno->inUFMunNascto : null,
                    'inCodMunNasctoDNE'                => $aluno->inCodMunNasctoDNE ? $aluno->inCodMunNasctoDNE : null,
                    'inDataEntradaPais'                => $aluno->inDataEntradaPais ? $aluno->inDataEntradaPais : null,
                    'inCodPaisOrigem'                  => $aluno->inCodPaisOrigem ? $aluno->inCodPaisOrigem : null,
                    'inPaisOrigem'                     => $aluno->inPaisOrigem ? $aluno->inPaisOrigem : null,
                ],
                'inDeficiencia' => [
                    'inCodNecessidade'         => $aluno->inCodNecessidade ? $aluno->inCodNecessidade : null,
                    'inMobilidadeReduzida'     => $aluno->inMobilidadeReduzida ? $aluno->inMobilidadeReduzida : null,
                    'inTipoMobilidadeReduzida' => $aluno->inTipoMobilidadeReduzida ? $aluno->inTipoMobilidadeReduzida : null,
                    'inCuidador'               => $aluno->inCuidador ? $aluno->inCuidador : null,
                    'inTipoCuidador'           => $aluno->inTipoCuidador ? $aluno->inTipoCuidador : null,
                    'inProfSaude'              => $aluno->inProfSaude ? $aluno->inProfSaude : null,
                    'inTipoProfSaude'          => $aluno->inTipoProfSaude ? $aluno->inTipoProfSaude : null,
                ],
                'inRecursoAvaliacao' => [
                    'inNenhum'                => $aluno->inNenhum ? $aluno->inNenhum : null,
                    'inAuxilioLeitor'         => $aluno->inAuxilioLeitor ? $aluno->inAuxilioLeitor : null,
                    'inAuxilioTranscricao'    => $aluno->inAuxilioTranscricao ? $aluno->inAuxilioTranscricao : null,
                    'inGuiaInterprete'        => $aluno->inGuiaInterprete ? $aluno->inGuiaInterprete : null,
                    'inInterpreteLibras'      => $aluno->inInterpreteLibras ? $aluno->inInterpreteLibras : null,
                    'inLeituraLabial'         => $aluno->inLeituraLabial ? $aluno->inLeituraLabial : null,
                    'inProvaBraile'           => $aluno->inProvaBraile ? $aluno->inProvaBraile : null,
                    'inProvaAmpliada'         => $aluno->inProvaAmpliada ? $aluno->inProvaAmpliada : null,
                    'inFonteProva'            => $aluno->inFonteProva ? $aluno->inFonteProva : null,
                    'inProvaVideoLibras'      => $aluno->inProvaVideoLibras ? $aluno->inProvaVideoLibras : null,
                    'inCdAudioDefVisual'      => $aluno->inCdAudioDefVisual ? $aluno->inCdAudioDefVisual : null,
                    'inProvaLinguaPortuguesa' => $aluno->inProvaLinguaPortuguesa ? $aluno->inProvaLinguaPortuguesa : null,
                ],
                'inDocumentos' => [
                    'inNumDoctoCivil'           => $aluno->inNumDoctoCivil ? $aluno->inNumDoctoCivil : null,
                    'inDigitoDoctoCivil'        => $aluno->inDigitoDoctoCivil ? $aluno->inDigitoDoctoCivil : null,
                    'inUFDoctoCivil'            => $aluno->inUFDoctoCivil ? $aluno->inUFDoctoCivil : null,
                    'inDataEmissaoDoctoCivil'   => $aluno->inDataEmissaoDoctoCivil ? $aluno->inDataEmissaoDoctoCivil : null,
                    'inNumNIS'                  => $aluno->inNumNIS ? $aluno->inNumNIS : null,
                    'inCodigoINEP'              => $aluno->inCodigoINEP ? $aluno->inCodigoINEP : null,
                    'inCPF'                     => $aluno->inCPF ? $aluno->inCPF : null,
                    'inJustificativaDocumentos' => $aluno->inJustificativaDocumentos ? $aluno->inJustificativaDocumentos : null,
                ],
                'inCertidaoAntiga' => [
                    'inNumCertidao'         => $aluno->inNumCertidao ? $aluno->inNumCertidao : null,
                    'inLivro'               => $aluno->inLivro ? $aluno->inLivro : null,
                    'inFolha'               => $aluno->inFolha ? $aluno->inFolha : null,
                    'inDistritoCertidao'    => $aluno->inDistritoCertidao ? $aluno->inDistritoCertidao : null,
                    'inMunicipioComarca'    => $aluno->inMunicipioComarca ? $aluno->inMunicipioComarca : null,
                    'inUFComarca'           => $aluno->inUFComarca ? $aluno->inUFComarca : null,
                    'inDataEmissaoCertidao' => $aluno->inDataEmissaoCertidao ? $aluno->inDataEmissaoCertidao : null,
                ],
                'inCertidaoNova' => [
                    'inCertMatr01' => $aluno->inCertMatr01 ? $aluno->inCertMatr01 : null,
                    'inCertMatr02' => $aluno->inCertMatr02 ? $aluno->inCertMatr02 : null,
                    'inCertMatr03' => $aluno->inCertMatr03 ? $aluno->inCertMatr03 : null,
                    'inCertMatr04' => $aluno->inCertMatr04 ? $aluno->inCertMatr04 : null,
                    'inCertMatr05' => $aluno->inCertMatr05 ? $aluno->inCertMatr05 : null,
                    'inCertMatr06' => $aluno->inCertMatr06 ? $aluno->inCertMatr06 : null,
                    'inCertMatr07' => $aluno->inCertMatr07 ? $aluno->inCertMatr07 : null,
                    'inCertMatr08' => $aluno->inCertMatr08 ? $aluno->inCertMatr08 : null,
                    'inCertMatr09' => $aluno->inCertMatr09 ? $aluno->inCertMatr09 : null,
                    'inDataEmissaoCertidao' => $aluno->inDataEmissaoCertidao ? $aluno->inDataEmissaoCertidao : null,
                ],
                'inEnderecoResidencial' => [
                    'inLogradouro'                 => $aluno->inLogradouro ? $aluno->inLogradouro : null,
                    'inNumero'                     => $aluno->inNumero ? $aluno->inNumero : null,
                    'inBairro'                     => $aluno->inBairro ? $aluno->inBairro : null,
                    'inNomeCidade'                 => $aluno->inNomeCidade ? $aluno->inNomeCidade : null,
                    'inUFCidade'                   => $aluno->inUFCidade ? $aluno->inUFCidade : null,
                    'inComplemento'                => $aluno->inComplemento ? $aluno->inComplemento : null,
                    'inCep'                        => $aluno->inCep ? $aluno->inCep : null,
                    'inAreaLogradouro'             => isset($aluno->inAreaLogradouro) ? $aluno->inAreaLogradouro : null,
                    'inCodLocalizacaoDiferenciada' => $aluno->inCodLocalizacaoDiferenciada ? $aluno->inCodLocalizacaoDiferenciada : null,
                    'inCodMunicipioDNE'            => $aluno->inCodMunicipioDNE ? $aluno->inCodMunicipioDNE : null,
                    'inLatitude'                   => $aluno->inLatitude ? $aluno->inLatitude : null,
                    'inLongitude'                  => $aluno->inLongitude ? $aluno->inLongitude : null,
                ],
                'inRastreio' => [
                    'inUsuarioRemoto'     => $aluno->inUsuarioRemoto ? $aluno->inUsuarioRemoto : null,
                    'inNomeUsuario'       => $aluno->inNomeUsuario ? $aluno->inNomeUsuario : null,
                    'inNumCPF'            => $aluno->inNumCPF ? $aluno->inNumCPF : null,
                    'inLocalPerfilAcesso' => $aluno->inLocalPerfilAcesso ? $aluno->inLocalPerfilAcesso : null,
                ]
            ]
        );

        return $response;
    }
}
