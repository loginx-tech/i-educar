<?php

use App\Http\Controllers\SedController;
use Illuminate\Support\Facades\Route;

// Alunos
Route::get('/intranet/sed/aluno/create/{cod}', [SedController::class, 'createAluno'])->name('sed.aluno.create');
Route::post('/intranet/sed/aluno/store/{cod}', [SedController::class, 'storeAluno'])->name('sed.aluno.store');

// Salas
Route::get('/sed/class/{cod_escola}/create', [SedController::class, 'createAluno'])->name('sed.class.create');

// Escolas
Route::get('/sed/school/{cod}', [SedController::class, 'getSchool'])->name('sed.school.get'); // Cadastro escola

// APIs Internas (return JSON) |----------------------------------------------------------------------------------------|

Route::get('/consulta-ra/{ra}', [SedController::class, 'consultaRa'])->name('sed.consulta.ra');
