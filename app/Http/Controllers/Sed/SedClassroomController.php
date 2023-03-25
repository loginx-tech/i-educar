<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Services\Sed\Alunos\{
    GetAlunoService,
    StoreAlunoService
};
use clsPmieducarTurma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SedClassroomController extends Controller
{
    public function __construct(
        protected StoreAlunoService $storeAlunoService,
    ) {
        //$this->middleware('auth');
    }

    public function editCod($codClass, Request $request)
    {
        DB::table('pmieducar.turma_sed')->insert([
            'cod_turma_id' => $codClass,
            'cod_sed' => $request->cod_sed,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //dd('editCod', $codClass);
        // $lst_obj = (new clsPmieducarTurma())->lista(
        //     int_cod_turma: $codClass,
        //     visivel: [
        //         'true',
        //         'false'
        //     ]
        // );

        dd('editCod');
    }

    public function edit($codClass)
    {
        dd('edit');
    }

    public function update($codClass)
    {
        dd('update');
    }
}
