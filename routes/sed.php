<?php

use App\Http\Controllers\Sed\{SedClassroomController, SedController, SedStudentController};
use Illuminate\Support\Facades\Route;

// Alunos
Route::get('/intranet/sed/aluno/create/{cod}', [SedController::class, 'createAluno'])->name('sed.aluno.create');
Route::post('/intranet/sed/aluno/store/{cod}', [SedController::class, 'storeAluno'])->name('sed.aluno.store');

Route::get('/intranet/sed/matricular/{matricula_id}/aluno/{aluno_id}', [SedStudentController::class, 'createMatricula'])->name('sed.matricula.edit');
Route::post('/sed/matricular/{matricula_id}/aluno/{cod}/store', [SedStudentController::class, 'storeMatricula'])->name('sed.matricula.store');

// Escolas
Route::get('/sed/school/{cod}', [SedController::class, 'getSchool'])->name('sed.school.get'); // Cadastro escola

// Salas
Route::get('/intranet/sed/salas/{cod_class}/situacao-sed', [SedClassroomController::class, 'check'])->name('sed.class.check');

Route::get('/sed/salas/{cod_class}/atribuir-codigo', [SedClassroomController::class, 'createOrEditCod'])->name('sed.class.create-code');
Route::post('/sed/salas/{cod_class}/set-codigo', [SedClassroomController::class, 'storeOrUpdateCode'])->name('sed.class.store-code');

Route::get('/sed/salas/{cod_class}/criar', [SedClassroomController::class, 'create'])->name('sed.class.create'); //TO-DO FIX
Route::post('/sed/salas/{cod_class}/store', [SedClassroomController::class, 'store'])->name('sed.class.store'); //TO-DO FIX

Route::get('/sed/salas/{cod_class}/editar', [SedClassroomController::class, 'edit'])->name('sed.class.edit');
Route::post('/sed/salas/{cod_class}/update', [SedClassroomController::class, 'update'])->name('sed.class.update');

// APIs Internas (return JSON) |----------------------------------------------------------------------------------------|

Route::get('/consulta-ra/{ra}', [SedController::class, 'consultaRa'])->name('sed.consulta.ra');

/*
    routes/web.php                                             -  adicionei a importação do arquivo sed.php, e adicionei o ->name('intranet.page'); em uma das rotas do ieducar
    ieducar/intranet/educar_aluno_det.php                      - adicionei o link para a tela de cadastro de aluno no SED, comentei a função de uniformes
    ieducar/intranet/educar_escola_det.php                     - adicionei o link para a tela de cadastro de escola no SED
    ieducar/intranet/educar_matricula_det.php                  - adicionei o link para a tela de cadastro de matricula no SED
    ieducar/intranet/educar_turma_det.php                      - adicionei o link para a tela de cadastro de turma no SED
    modules/Cadastro/Views/AlunoController.php                 - adicionei a importação do java script ConsultaRA.js
    public/vendor/legacy/Cadastro/Assets/Javascripts/Aluno.js  - adicionei selected na opção de solteiro no input de estado civil

*/
