<?php

use App\Http\Controllers\SedController;
use Illuminate\Support\Facades\Route;

// Alunos
Route::get('/intranet/sed/aluno/create/{cod}', [SedController::class, 'createAluno'])->name('sed.aluno.create');
Route::post('/intranet/sed/aluno/store/{cod}', [SedController::class, 'storeAluno'])->name('sed.aluno.store');

// Salas
Route::get('/intranet/sed/class/create/{cod}', [SedController::class, 'createAluno'])->name('sed.class.create');

// APIs Internas (JSON) (Padrao Web)

Route::get('/consulta-ra/{ra}', [SedController::class, 'consultaRa'])->name('sed.consulta.ra');
