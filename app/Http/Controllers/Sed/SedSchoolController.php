<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sed\Class\StoreUpdateClassRequest;
use App\Http\Requests\Sed\SetClassCodeRequest;
use App\Services\Sed\Escolas\GetUnidadesByEscolaService;
use clsPmieducarEscola;
use clsPmieducarTurma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SedSchoolController extends Controller
{
    public function __construct(
        protected GetUnidadesByEscolaService $getUnidadesByEscolaService,
    ) {
        //$this->middleware('auth');
    }
    
}
