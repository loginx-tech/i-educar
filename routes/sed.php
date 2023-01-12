<?php

use App\Http\Controllers\SedController;
use Illuminate\Support\Facades\Route;

Route::get('/intranet/sed/aluno/create/{cod}', [SedController::class, 'createAluno'])->name('sed.aluno.create');
Route::post('/intranet/sed/aluno/store/{cod}', [SedController::class, 'storeAluno'])->name('sed.aluno.store');

// APIs Internas (Padrao Web)

Route::get('/consulta-ra/{ra}', [SedController::class, 'consultaRa'])->name('sed.consulta.ra');
