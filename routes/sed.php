<?php

use App\Http\Controllers\Sed\{SedClassroomController, SedController, SedStudentController};
use Illuminate\Support\Facades\Route;

// Alunos |--------------------------------------------------------------------------------------------------------------|

Route::get('/intranet/sed/aluno/create/{cod}', [SedController::class, 'createAluno'])->name('sed.aluno.create');
Route::post('/intranet/sed/aluno/store/{cod}', [SedController::class, 'storeAluno'])->name('sed.aluno.store');

Route::get('/intranet/sed/matricular/{matricula_id}/aluno/{cod}', [SedStudentController::class, 'createMatricula'])->name('sed.matricula.edit');
Route::post('/sed/matricular/{matricula_cod}/aluno/{cod}/store', [SedStudentController::class, 'storeMatricula'])->name('sed.matricula.store');

// - Movimentações
Route::get('/intranet/sed/aluno/{cod_aluno}/sala/{cod_sala}/remanejar', [SedStudentController::class, 'createRemanejamento'])->name('sed.remanejamento.create');
Route::post('/sed/aluno/{cod_aluno}/sala/{cod_sala}/remanejar', [SedStudentController::class, 'storeRemanejamento'])->name('sed.remanejamento.store');

Route::get('/intranet/sed/aluno/{cod_aluno}/sala/{cod_sala}/transferir', [SedStudentController::class, 'preCreateTransferencia'])->name('sed.transferencia.pre-create');
Route::get('/intranet/sed/aluno/{cod_aluno}/sala/{cod_sala}/escola/{cod_escola}/transferir', [SedStudentController::class, 'createTransferencia'])->name('sed.transferencia.create');
Route::post('/sed/aluno/{cod}/transferir', [SedStudentController::class, 'storeTransferencia'])->name('sed.transferencia.store');

// Escolas |-------------------------------------------------------------------------------------------------------------|
Route::get('/sed/school/{cod}', [SedController::class, 'getSchool'])->name('sed.school.get'); // Cadastro escola

// Salas |---------------------------------------------------------------------------------------------------------------|
Route::get('/intranet/sed/salas/{cod_sala}/situacao-sed', [SedClassroomController::class, 'check'])->name('sed.class.check');

Route::get('/sed/salas/{cod_sala}/atribuir-codigo', [SedClassroomController::class, 'createOrEditCod'])->name('sed.class.create-code');
Route::post('/sed/salas/{cod_sala}/set-codigo', [SedClassroomController::class, 'storeOrUpdateCode'])->name('sed.class.store-code');

Route::get('/sed/salas/{cod_sala}/criar', [SedClassroomController::class, 'create'])->name('sed.class.create'); //TO-DO FIX
Route::post('/sed/salas/{cod_sala}/store', [SedClassroomController::class, 'store'])->name('sed.class.store'); //TO-DO FIX

Route::get('/sed/salas/{cod_sala}/editar', [SedClassroomController::class, 'edit'])->name('sed.class.edit');
Route::post('/sed/salas/{cod_sala}/update', [SedClassroomController::class, 'update'])->name('sed.class.update');

Route::get('/sed/salas/{cod_sala}/formacao', [SedClassroomController::class, 'formation'])->name('sed.class.formation');

// APIs Internas (return JSON) |----------------------------------------------------------------------------------------|

Route::get('/consulta-ra/{ra}', [SedController::class, 'consultaRa'])->name('sed.consulta.ra');
