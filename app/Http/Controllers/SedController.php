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

        $alunoRA = LegacyStudent::where('ref_idpes', $alunoDetalhe['ref_idpes'])->first();
        if ($alunoRA->state_registration_id) {
            return redirect()->route('intranet.page', 'educar_aluno_lst.php')->with('success', 'Esse aluno já possui RA no SED.');
        }

        $det_pessoa_pai = [];
        $det_pessoa_mae = [];

        // Pais
        if ($det_fisica['idpes_pai']) {
            $obj_pessoa_pai = new clsPessoaFj($det_fisica['idpes_pai']);
            $det_pessoa_pai = $obj_pessoa_pai->detalhe();

        // if ($det_pessoa_pai) {
        //     $nome_pai = $det_pessoa_pai['nome'];

        //     // CPF
        //     $obj_cpf = new clsFisica($idpes_pai);
        //     $det_cpf = $obj_cpf->detalhe();

        //     if ($det_cpf['cpf']) {
        //         $cpf_pai = $det_cpf['cpf'];
        //     }
        // }
        } else {
            $det_pessoa_pai['nome'] = '';
        }

        if ($det_fisica['idpes_mae']) {
            $obj_pessoa_mae = new clsPessoaFj($det_fisica['idpes_mae']);
            $det_pessoa_mae = $obj_pessoa_mae->detalhe();

        // if ($det_pessoa_mae) {
        //     $nome_mae = $det_pessoa_mae['nome'];

        //     // CPF
        //     $obj_cpf = new clsFisica($idpes_mae);
        //     $det_cpf = $obj_cpf->detalhe();

        //     if ($det_cpf['cpf']) {
        //         $cpf_mae = $det_cpf['cpf'];
        //     }
        // }
        } else {
            $det_pessoa_mae['nome'] = '';
        }

        return view('sed.store-aluno', [
            'aluno' => $aluno->detalhe(),
            'user' => $user,
            'codAluno' => $codAluno,
            'obj_pessoa_fj' => $obj_pessoa_fj,
            'det_fisica' => $det_fisica,
            'det_pessoa_pai' => $det_pessoa_pai,
            'det_pessoa_mae' => $det_pessoa_mae,
        ]);
    }

    public function storeAluno($codAluno, SedStoreAlunoRequest $request)
    {
        //Retira acentos e caracteres especiais e ifens da cidade
        if ($request->inNomeMunNascto) {
            $request->inNomeMunNascto = str_replace('-', ' ', preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $request->inNomeMunNascto)));
        }

        if ($request->inNomeCidade) {
            $request->inNomeCidade = str_replace('-', ' ', preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $request->inNomeCidade)));
        }

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
        // Verifica se as funções do sed estao ativas
        $sed = $sedService->getConfigSystemSed();
        if (!$sed) {
            return response()->json([
                'status' => 'disabled',
            ], 200);
        }

        // Verifica se nao existe esse Ra cadastrado no ieducar
        $alunoRA = LegacyStudent::where('aluno_estado_id', $ra)->first();
        if ($alunoRA) {
            return response()->json([
                'status' => 'error',
                'message' => 'Este RA já possui cadastro no sistema, acesse-o pela listagem de alunos.',
            ], 200);
        }

        // Retira o Digito
        if (strlen($ra) == 13 || strlen($ra) == 10) {
            $ra = substr($ra, 0, -1);
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
