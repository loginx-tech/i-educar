<?php

//Inutilizada

namespace App\Services\Sed\Escolas;

use App\Models\Escola;
use Illuminate\Support\Facades\{DB};

class SyncEscolasService
{
    public function __construct(
        //protected Escola $escola,
        protected GetEscolasService $getEscolasService
    ) {
    }

    /**
     * Retorna todas as escolas cadastradas no SED na diretoria informada
     *
     */
    public function __invoke()
    {
        $escolas =  ($this->getEscolasService)();
    }
}
