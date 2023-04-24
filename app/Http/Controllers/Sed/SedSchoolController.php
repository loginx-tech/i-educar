<?php

namespace App\Http\Controllers\Sed;

use App\Http\Controllers\Controller;
use App\Services\Sed\Escolas\GetUnidadesByEscolaService;
use Illuminate\Support\Facades\Auth;

class SedSchoolController extends Controller
{
    public function __construct(
        protected GetUnidadesByEscolaService $getUnidadesByEscolaService,
    ) {
        //$this->middleware('auth');
    }
}
