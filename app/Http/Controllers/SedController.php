<?php

namespace App\Http\Controllers;

use App\Http\Requests\SedStoreAlunoRequest;
use App\Models\LegacyStudent;
use App\Services\Sed\Alunos\{
    GetAlunoService,
    StoreAlunoService
};
use clsFisica;
use clsPessoaFj;
use clsPmieducarAluno;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class SedController extends Controller
{
    public function __construct(
        protected StoreAlunoService $storeAlunoService,
        protected GetAlunoService $getAlunoService
    ) {
        //$this->middleware('auth');
    }

    public function createAluno($codAluno)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            abort(403, 'Sistema Escolar Digital(SED) não está habilitado para esta cidade.');
        }

        $this->menu(999847);

        $user  = Auth::user();
        $aluno = new clsPmieducarAluno($codAluno);
        $alunoDetalhe = $aluno->detalhe();

        $obj_fisica = new clsFisica($alunoDetalhe['ref_idpes']);
        $det_fisica = $obj_fisica->detalhe();

        $det_pessoa_fj = new clsPessoaFj($alunoDetalhe['ref_idpes']);
        $obj_pessoa_fj = $det_pessoa_fj->detalhe();

        return view('sed.store-aluno', ['aluno' => $aluno->detalhe(), 'user' => $user, 'codAluno' => $codAluno, 'obj_pessoa_fj' => $obj_pessoa_fj, 'det_fisica' => $det_fisica]);
    }

    public function storeAluno($codAluno, SedStoreAlunoRequest $request)
    {
        $response = ($this->storeAlunoService)($request);
        $responseObj = $response->collect();

        if ($response->failed() || isset($responseObj['outErro'])) {
            return back()->withInput()->withErrors(['Error' => $responseObj['outErro']]);
        }

        // Salva o RA no banco de dados
        $aluno = new clsPmieducarAluno($codAluno);
        $alunoDtl = $aluno->detalhe();
        $alunoNew = LegacyStudent::where('ref_idpes', $alunoDtl['ref_idpes'])->first();
        $alunoNew->state_registration_id = $responseObj['outAluno']['outNumRA'] . $responseObj['outAluno']['outDigitoRA'];
        $alunoNew->saveOrFail();

        return redirect()->route('intranet.page', 'educar_aluno_lst.php')->with('success', 'Ficha aluno salva com sucesso no SED. Novo RA registrado.');
    }

    public function consultaRa($ra)
    {
        $sedService = new \App\Services\Sed\AuthService();
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            return response()->json([
                'status' => 'disabled',
            ], 200);
        }

        $response = ($this->getAlunoService)($ra);
        $responseObj = $response->collect();

        if (isset($responseObj['outErro'])) {
            return response()->json([
                'status' => 'error',
                'message' => $responseObj['outErro'] == 'Nenhum aluno encontrado com o inNumRA, inDigitoRA e inSiglaUFRA informados.' ? 'RA não encontrado no SED.' : $responseObj['outErro'],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'RA encontrado no SED.',
            'aluno' => $responseObj,
        ], 200);


    }
}


