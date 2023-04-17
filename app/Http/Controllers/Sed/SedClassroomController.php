<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sed\Class\StoreUpdateClassRequest;
use App\Http\Requests\Sed\SetClassCodeRequest;
use App\Services\Sed\Classrooms\GetClassroomService;
use App\Services\Sed\Classrooms\StoreClassService;
use App\Services\Sed\Classrooms\UpdateClassService;
use App\Services\Sed\DadosBasicos\GetTiposClasseService;
use App\Services\Sed\DadosBasicos\GetTiposEnsinoService;
use App\Services\Sed\Escolas\GetEscolaByName;
use App\Services\Sed\Escolas\GetUnidadesByEscolaService;
use clsPmieducarEscola;
use clsPmieducarTurma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SedClassroomController extends Controller
{
    public function __construct(
        protected StoreClassService $storeClassService,
        protected UpdateClassService $updateClassService,
        protected GetClassroomService $getClassroomService,
        protected GetTiposEnsinoService $getTiposEnsinoService,
        protected GetTiposClasseService $getTiposClasseService,
        protected GetUnidadesByEscolaService $getUnidadesByEscolaService,
    ) {
        //$this->middleware('auth');
    }

    public function check($codClass)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();

        if (!$classSed) {
            return redirect()->route('sed.class.create-code', $codClass)->with('success', 'Turma não possui código SED.');
        } else {
            return redirect()->route('sed.class.edit', $codClass)->with('success', 'Cadastro SED encontrado.');
        }
    }

    public function createOrEditCod($codClass)
    {
        $this->menu(999847);

        $lst_obj = (new clsPmieducarTurma())->lista(
            int_cod_turma: $codClass,
            visivel: [
                'true',
                'false'
            ]
        );

        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();

        return view('sed.classrooms.set-code', [
            'class' => $lst_obj,
            'classSed' => $classSed,
            'action' => $classSed ? 'edit' : 'create',
            'codClass' => $codClass,
        ]);
    }

    public function storeOrUpdateCode($codClass, SetClassCodeRequest $request)
    {
        $classSed = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();

        if (!$classSed) {
            DB::table('pmieducar.turma_sed')->insert([
                'cod_turma_id' => $codClass,
                'cod_sed' => $request->codinCodSed_sed,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->update([
                'cod_sed' => $request->inCodSed,
                'updated_at' => now()
            ]);
        }

        return redirect()->route('sed.class.edit', $codClass)->with('success', 'Código SED da turma atualizado com sucesso.');
    }

    public function create($codClass)
    {
        $this->menu(999847);

        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $classSedLocal = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();
        if ($classSedLocal) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass)
            ->with('error', 'A turma já está vinculada a uma sala cadastrada no SED. Edite a sala para atualizar os dados, ou altere o código SED da turma para criar uma nova sala.');
        }

        $tiposClasse = ($this->getTiposClasseService)();
        $tiposEnsino = ($this->getTiposEnsinoService)();

        $obj_escola = new clsPmieducarEscola();
        $obj_escola->setOrderby('nome');
        $escolas = $obj_escola->lista();

        return view('sed.classrooms.create', [
            'codClass' => $codClass,
            'tiposClasse' => $tiposClasse->object()->outTipoClasse,
            'tiposEnsino' => $tiposEnsino->object()->outTipoEnsino,
            'escolas' => $escolas,
        ]);
    }

    public function store(StoreUpdateClassRequest $request, $codClass)
    {
        $this->menu(999847);

        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $classSedLocal = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();
        if ($classSedLocal) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass)
            ->with('error', 'A turma já está vinculada a uma sala cadastrada no SED. Edite a sala para atualizar os dados, ou altere o código SED da turma para criar uma nova sala.');
        }

        $escolaUnidades = ($this->getUnidadesByEscolaService)($request->inCodEscola);
        $escolaObj = $escolaUnidades->collect();
        if ($escolaUnidades->failed() || isset($escolaObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $escolaObj['outErro']]);
        }

        //Adicionando a primeira unidade padrão da escola ; TODO: Adicionar opção de escolher a unidade
        $request->request->add(['inCodUnidade' => $escolaUnidades->object()->outUnidade[0]->outCodUnidade]); //add request

        $response = ($this->storeClassService)($request);
        $responseObj = $response->collect();
        if ($response->failed() || isset($responseObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $responseObj['outErro']]);
        }

        // Criando vinculo entre a turma e a sala SED
        DB::table('pmieducar.turma_sed')->create([
            'cod_turma_id' => $codClass,
            'cod_sed' => $responseObj->object()->outCodSala,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('intranet.page', 'educar_turma_lst.php')->with('success', 'Cadastro SED criado com sucesso.');
    }

    public function edit($codClass)
    {
        $this->menu(999847);

        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $classSedLocal = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();

        if (!$classSedLocal) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass)
            ->with('error', 'A turma não está vinculada a uma sala cadastrada no SED.
            Por favor, cadastre o código SED da turma ou crie um novo cadastro antes de editar o cadastro SED.');
        }

        $class = ($this->getClassroomService)($classSedLocal->cod_sed);
        $tiposClasse = ($this->getTiposClasseService)();
        $tiposEnsino = ($this->getTiposEnsinoService)();

        $obj_escola = new clsPmieducarEscola();
        $obj_escola->setOrderby('nome');
        $escolas = $obj_escola->lista();

        return view('sed.classrooms.edit', [
            'codClass' => $codClass,
            'class' => $class,
            'tiposClasse' => $tiposClasse->object()->outTipoClasse,
            'tiposEnsino' => $tiposEnsino->object()->outTipoEnsino,
            'escolas' => $escolas,
        ]);
    }

    public function update(StoreUpdateClassRequest $request, $codClass)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $classSedLocal = DB::table('pmieducar.turma_sed')->where('cod_turma_id', $codClass)->first();
        if (!$classSedLocal) {
            return redirect()->route('intranet.page', 'educar_turma_det.php?cod_turma=' . $codClass)
            ->with('error', 'A turma não está vinculada a uma sala cadastrada no SED.
            Por favor, cadastre o código SED da turma ou crie um novo cadastro antes de editar o cadastro SED.');
        }

        $response = ($this->updateClassService)($request);
        $responseObj = $response->collect();

        if ($response->failed() || isset($responseObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $responseObj['outErro']]);
        }

        return redirect()->route('intranet.page', 'educar_turma_lst.php')->with('success', 'Cadastro SED atualizado com sucesso.');
    }
}
