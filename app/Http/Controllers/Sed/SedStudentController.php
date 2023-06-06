<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sed\Student\StoreRemanejamento;
use App\Services\Sed\Alunos\GetAlunoService;
use App\Services\Sed\Alunos\StoreMatriculaService;
use App\Services\Sed\Alunos\StoreRemanejamentoService;
use App\Services\Sed\Classrooms\GetClassroomService;
use App\Services\Sed\Classrooms\GetClassroomsService;
use App\Services\Sed\DadosBasicos\GetTiposClasseService;
use App\Services\Sed\DadosBasicos\GetTiposEnsinoService;
use App\Services\Sed\DadosBasicos\TipoEnsinoService;
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
    protected $inSiglaUFRA = 'SP'; // TODO: Pegar de uma configuração
    protected $inAnoLetivo;

    public function __construct(
        protected GetUnidadesByEscolaService $getUnidadesByEscolaService,
        protected GetTiposEnsinoService $getTiposEnsinoService,
        protected GetTiposClasseService $getTiposClasseService,
        protected StoreMatriculaService $storeMatriculaService,
        protected GetClassroomService $getClassroomService,
        protected GetAlunoService $getAlunoService,
        protected GetClassroomsService $getClassroomsService,
        protected StoreRemanejamentoService $storeRemanejamentoService,
    ) {
        $this->inAnoLetivo = date('Y'); // TODO: Pegar de uma configuração
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
            // return redirect()->route('intranet.page', 'educar_aluno_det.php?cod_aluno=' . $aluno_cod)->with('error', 'Matrícula não encontrada.');
            return redirect()
            ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
            ->with('error', 'Matrícula não encontrada.');
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
            return redirect()
                ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
                ->with('error', 'O aluno(a) " ' . $nm_aluno . ' " não possui RA cadastrado no i-educar.');
        }

        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $enturmacoes[0]['ref_cod_turma'])->first();
        if (!$classSed) {
            return redirect()
            ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
            ->with('error', 'A turma que o aluno(a) " ' . $nm_aluno . ' " está matriculado(a) não possui código SED cadastrado no i-educar.');
        }

        return view('sed.students.create-matricula', [
            'aluno' => $det_aluno,
            'codAluno' => $aluno_cod,
            'matricula' => $registro,
            'codMatricula' => $matricula_cod,
            'enturmacoes' => $enturmacoes[0],
        ]);
    }

    public function StoreMatricula($matricula_cod, $aluno_cod, Request $request)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

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

            return redirect()
                ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
                ->with('error', 'O aluno(a) " ' . $nm_aluno . ' " não possui RA cadastrado no i-educar.');
        }

        // Retira pontuações do RA e o digito verificador

        $ra = explode('-', $det_aluno['aluno_estado_id']);
        $ra = preg_replace('/[^0-9]/', '', $ra[0]);

        if (strlen($ra) == 13 || strlen($ra) == 10) {
            $ra = substr($ra, 0, -1);
        }
        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $enturmacoes[0]['ref_cod_turma'])->first();
        if (!$classSed) {

            return redirect()
                ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
                ->with('error', 'A turma que o aluno(a) " ' . $nm_aluno . ' " está matriculado(a) não possui código SED cadastrado no i-educar.');
        }

        $class = ($this->getClassroomService)($classSed->cod_sed);
        if (isset($class['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=' . $classSed->cod_turma_id)
                ->with('error', 'Algo de errado aconteceu: ' . $class['outErro'] . '. Por favor, tente novamente.');
        }

        $data_matricula = [
            'inAnoLetivo' => date('Y'),
            'inNumRA'     => $ra,
            //"inDigitoRA"  => "",
            'inSiglaUFRA' => config('sed.inSiglaUFRA'),

            'inDataInicioMatricula' => $enturmacoes[0]['data_enturmacao'],
            // "inNumAluno"  => "",
            'inNumClasse' => $classSed->cod_sed,

            'inCodTipoEnsino' => $class['outCodTipoEnsino'],
            'inCodSerieAno'   => $class['outCodSerieAno'],
        ];

        $response = ($this->storeMatriculaService)($data_matricula);
        $responseObj = $response->collect();

        if ($response->failed() || isset($responseObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $responseObj['outErro']]);
        }

        return redirect()
                    ->route('intranet.page', 'educar_matricula_det.php?cod_matricula=' . $matricula_cod)
                    ->with('success', 'Matricula SED criada com sucesso.');
    }

    /**
     * Create remanejamento
     *
     * @param string $aluno_ra
     * @param int $sala_cod (Sala atual do aluno)
     * @return View
     */
    public function createRemanejamento($aluno_ra, $sala_cod)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $this->menu(999847);

        // Get classroom
        $response_sala = ($this->getClassroomService)($sala_cod);
        if (isset($response_sala['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_sala['outErro'] . '. Por favor, tente novamente.');
        }

        // Get student
        $response_aluno = ($this->getAlunoService)($aluno_ra, $this->inSiglaUFRA)->collect();
        if (isset($response_aluno['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_aluno['outErro'] . '. Por favor, tente novamente.');
        }

        // Get class options
        $response_salas_opcoes = ($this->getClassroomsService)($response_sala['outCodEscola'], $response_sala['outAnoLetivo'] ?? $this->inAnoLetivo);
        if (isset($response_aluno['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_aluno['outErro'] . '. Por favor, tente novamente.');
        }

        $response_tipo_ensinos = ($this->getTiposEnsinoService)()->collect();
        if (isset($response_tipo_ensinos['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_tipo_ensinos['outErro'] . '. Por favor, tente novamente.');
        }

        // Inserindo a descrição do tipo de ensino para nomear as turmas (O sed só retorna o código do tipo de ensino)
        $response_salas_opcoes = TipoEnsinoService::mapDescricao($response_salas_opcoes['outClasses'], $response_tipo_ensinos['outTipoEnsino']);

        return view('sed.students.create-remanejamento', [
            'aluno_ra' => $aluno_ra,
            'sala_cod' => $sala_cod,
            'sala_atual' => $response_sala,
            'aluno' => $response_aluno,
            'sala_opcoes' => $response_salas_opcoes ?? [],
        ]);
    }

    public function storeRemanejamento(StoreRemanejamento $request, $aluno_ra, $sala_cod)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        // Get classroom (Sala de destino)
        $response_sala = ($this->getClassroomService)($request['inNumClasseDestino']);
        if (isset($response_sala['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_sala['outErro'] . '. Por favor, tente novamente.');
        }

        // Get student
        $response_aluno = ($this->getAlunoService)($aluno_ra, $this->inSiglaUFRA)->collect();
        if (isset($response_aluno['outErro'])) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=')
                ->with('error', 'Algo de errado aconteceu: ' . $response_aluno['outErro'] . '. Por favor, tente novamente.');
        }

        $data = [
            'inNumRA'     => $aluno_ra,
            // 'inDigitoRA'  => ,
            'inSiglaUFRA' => $response_aluno['outDadosPessoais']['outSiglaUFRA'],

            'inDataMovimento'    => $request['inDataMovimento'],
            // 'inNumAluno'         => ,
            'inNumClasseOrigem'  => $sala_cod,
            'inNumClasseDestino' => $request['inNumClasseDestino'],

            'inCodTipoEnsino' => $response_sala['outCodTipoEnsino'],
            'inCodSerieAno'   => $response_sala['outCodSerieAno'],
            'inAnoLetivo'     => $response_sala['outAnoLetivo'],
        ];

        $response = ($this->storeRemanejamentoService)($data);
        $responseObj = $response->collect();

        if ($response->failed() || isset($responseObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $responseObj['outErro']]);
        }

        return redirect()
                    ->route('sed.class.formation', $sala_cod)
                    ->with('success', 'Remanejamento SED realizado com sucesso.');
    }

    public function createTransferencia($aluno_cod)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $this->menu(999847);

        // return view('sed.students.create-transferencia', [

        // ]);
    }

    public function storeTransferencia(Request $request, $aluno_cod)
    {

    }
}
