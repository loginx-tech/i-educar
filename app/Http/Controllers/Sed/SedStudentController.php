<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Services\Sed\DadosBasicos\GetTiposClasseService;
use App\Services\Sed\DadosBasicos\GetTiposEnsinoService;
use App\Services\Sed\Escolas\GetUnidadesByEscolaService;
use clsPmieducarAluno;
use clsPmieducarCurso;
use clsPmieducarEscola;
use clsPmieducarInstituicao;
use clsPmieducarMatricula;
use clsPmieducarMatriculaTurma;
use clsPmieducarSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SedStudentController extends Controller
{
    public function __construct(
        protected GetUnidadesByEscolaService $getUnidadesByEscolaService,
        protected GetTiposEnsinoService $getTiposEnsinoService,
        protected GetTiposClasseService $getTiposClasseService,
    ) {
        //$this->middleware('auth');
    }

    /**
     * Esse método com finalidade a criação de matriculas de continuidade (rematricula), efetivação de
     * inscrições e definições (matricula antecipada) e matriculas nos demais tipos de ensino (educação infantil,
     * ensino profissionalizante, atividade complementar, etc..)
     *
     * @param Request $request
     *
     * @return View
     */
    public function CreateMatricula($matricula_cod, $aluno_cod)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $this->menu(999847);

        // --------------------- Matricula ---------------------

        $obj_matricula = new clsPmieducarMatricula();
        $lst_matricula = $obj_matricula->lista(int_cod_matricula: $matricula_cod);

        if ($lst_matricula) {
            $registro = array_shift(array: $lst_matricula);
        }

        if (!$registro) {
            return redirect()->route('intranet.page', 'educar_aluno_det.php?cod_aluno=' . $aluno_cod)->with('error', 'Matrícula não encontrada.');
        }

        $verificaMatriculaUltimoAno = $obj_matricula->verificaMatriculaUltimoAno(codAluno: $registro['ref_cod_aluno'], codMatricula: $registro['cod_matricula']);
        $existeSaidaEscola = $obj_matricula->existeSaidaEscola(codMatricula: $registro['cod_matricula']);

        // Curso
        $obj_ref_cod_curso = new clsPmieducarCurso(cod_curso: $registro['ref_cod_curso']);
        $det_ref_cod_curso = $obj_ref_cod_curso->detalhe();
        $curso_id = $registro['ref_cod_curso'];
        $registro['ref_cod_curso'] = $det_ref_cod_curso['nm_curso'];

        // Série
        $obj_serie = new clsPmieducarSerie(cod_serie: $registro['ref_ref_cod_serie']);
        $det_serie = $obj_serie->detalhe();
        $serie_id = $registro['ref_ref_cod_serie'];
        $registro['ref_ref_cod_serie'] = $det_serie['nm_serie'];

        // Nome da instituição
        $obj_cod_instituicao = new clsPmieducarInstituicao(cod_instituicao: $registro['ref_cod_instituicao']);
        $obj_cod_instituicao_det = $obj_cod_instituicao->detalhe();
        $registro['ref_cod_instituicao'] = $obj_cod_instituicao_det['nm_instituicao'];

        // Escola
        $obj_ref_cod_escola = new clsPmieducarEscola(cod_escola: $registro['ref_ref_cod_escola']);
        $det_ref_cod_escola = $obj_ref_cod_escola->detalhe();
        $escola_id = $registro['ref_ref_cod_escola'];
        $registro['ref_ref_cod_escola'] = $det_ref_cod_escola['nome'];

        // Nome do aluno
        $obj_aluno = new clsPmieducarAluno();
        $lst_aluno = $obj_aluno->lista(
            int_cod_aluno: $registro['ref_cod_aluno'],
            int_ativo: 1
        );

        if (is_array(value: $lst_aluno)) {
            $det_aluno = array_shift(array: $lst_aluno);
            $nm_aluno = $det_aluno['nome_aluno'];
        }

        // Nome da turma
        $enturmacoes = new clsPmieducarMatriculaTurma();
        $enturmacoes = $enturmacoes->lista(
            int_ref_cod_matricula: $matricula_cod
        );

        // ----------------------- Aluno ------------------------

        if (!$det_aluno['aluno_estado_id']) {
            return redirect()->route(
                'intranet.page',
                'educar_aluno_det.php?cod_aluno='.$aluno_cod
            )->with('error', 'O aluno(a) " ' . $nm_aluno . ' " não possui RA cadastrado no i-educar.');
        }

        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $enturmacoes[0]['ref_cod_turma'])->first();

        if ($classSed) {
            return redirect()->route(
                'intranet.page',
                'educar_aluno_det.php?cod_aluno='.$aluno_cod
            )->with('error', 'A turma que o aluno(a) " ' . $nm_aluno . ' " está matriculado(a) não possui código SED cadastrado no i-educar.');
        }

        //$tiposClasse = ($this->getTiposClasseService)();
        //$tiposEnsino = ($this->getTiposEnsinoService)();

        return view('sed.students.create-matricula', [
            'aluno' => $det_aluno,
            'codAluno' => $aluno_cod,
            'matricula' => $registro,
            'codMatricula' => $matricula_cod,
            'enturmacoes' => $enturmacoes[0],
            //'tiposClasse' => $tiposClasse->object()->outTipoClasse,
            //'tiposEnsino' => $tiposEnsino->object()->outTipoEnsino,
        ]);
    }

    public function StoreMatricula($matricula_cod, $aluno_cod, Request $request)
    {
        dd("Em Correção");
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }
    }

    // ---------------------------------------------------------------------------------------------
}
