<?php
//administrador
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\DiaHorarioController;
use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatedraticoController;
use App\Http\Controllers\GestionMateriasController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EstadoAlumnoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\BackupController;

//catedratico

use App\Http\Controllers\catedratico\homeController;
use App\Http\Controllers\catedratico\consultasController;
use App\Http\Controllers\catedratico\estadoAlumnoCatedraticoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    //catedratico
    Route::group(['prefix'=>'catedratico'], function() {
        //tablas de qr y estadistica
        Route::get('/materias-asistencia-id/{id}',[consultasController::class, 'catedraticoAsistenciaId'])->name('catedraticoAsistenciaIdController');
        //estado del alumno con los estados
        Route::get('estadoAlumno/{id}',[estadoAlumnoCatedraticoController::class,'index'])->name('catedraticoEstadoAlumnoIndex');
        Route::put('estadoAlumnoCatedratico/{asistencia_id}/{alumno_id}',[estadoAlumnoCatedraticoController::class,'cambiasEstado'])->name('catedraticoCambiasEstado');
        Route::get('/materias-asistencia-idCalculo/{id}',[consultasController::class, 'catedraticoEstadisticaAsistencia'])->name('catedraticoEstadisticaAsistencia');
        Route::post('/crear-asistencia',[homeController::class, 'catedraticoCrearAsistencia'])->name('catedraticoCrearAsistencia');
        Route::get('/{id}', [homeController::class, 'catedraticoIndex'])->name('catedarticoGestionMateriasIndex')->middleware('user.id');
        Route::get('/{user_id}/{materia_id}', [homeController::class, 'catedraticoAsistenciaMateriaAlumno'])->name('catedraticoAsistenciaMateriaAlumno')->middleware('user.id');
    });

    //administrador
    Route::group(['prefix'=>'admin'], function(){
        Route::get('/', [AdminController::class, 'index'])->name('AdminIndex')->middleware('permission:administrador');
        Route::get('/home', [AdminController::class, 'index'])->middleware('permission:administrador');
        //carreras
        Route::resource('/carreras', CarreraController::class)->middleware('permission:carrera');
        //Roles
        Route::resource('/roles', RoleController::class)->middleware('permission:rol');
        Route::get('/roles-id/{id}',[RoleController::class, 'rolPermisos'])->name('rolPermisos')->middleware('permission:rol');
        //usuarios
        Route::resource('/usuarios', UserController::class)->middleware('permission:usuario');
        Route::get('/usuarios/obtenerMateriasFacultad/{id}', [UserController::class, 'carrerasFacultad'])->middleware('permission:usuario');
        //materias
        Route::resource('/materias', MateriaController::class)->middleware('permission:materia');
        Route::get('/materias/obtenerMaterias/{id}', [MateriaController::class, 'carrerasFacultad'])->name('carrerasFacultad')->middleware('permission:materia');
        Route::get('/materias/obtenerCatedraticos/{id}', [MateriaController::class, 'carrerasUser'])->middleware('permission:materia');
        Route::get('/materias/obtenerTurno/{nombre}', [MateriaController::class, 'diaHorarioTurno'])->middleware('permission:materia');
        Route::get('/materias/obtenerTurnoNocturno/{nombre}', [MateriaController::class, 'diaHorarioTurnoNocturno'])->middleware('permission:materia');
        Route::get('/materias/obtenerTurnoNocturno2/{nombre}', [MateriaController::class, 'diaHorarioTurnoNocturno2'])->middleware('permission:materia');
        //horarios
        Route::get('/horarios', [DiaHorarioController::class, 'index'])->middleware('permission:horario');
        //alumnos
        Route::resource('/estudiantes', AlumnoController::class)->middleware('permission:alumno');
        Route::get('/estudiantes/obtenerCarreras/{id}', [AlumnoController::class, 'carrerasFacultad'])->middleware('permission:alumno');
        Route::get('/estudiantes/materiasAlumno/{id}', [AlumnoController::class, 'materiasAlumno'])->middleware('permission:alumno');
        Route::get('/estudiantes/materiasIndexAlumno/{id}', [AlumnoController::class, 'materiasindexAlumno'])->middleware('permission:alumno');

        //logicadeAsistencia
        //catedraticos
        Route::resource('/catedraticos', CatedraticoController::class)->middleware('permission:catedratico');
        //gestionmateriasporusuario
        Route::get('/gestion-materias/{id}', [GestionMateriasController::class, 'index'])->name('gestionMateriasIndex')->middleware('permission:catedratico');
        //getionpormateriasporusuario
        Route::get('/gestion-materias-asistencia/{user_id}/{materia_id}', [GestionMateriasController::class, 'asistenciaMateriaAlumno'])->name('asistenciaMateriaAlumno')->middleware('permission:asistencia');
        Route::post('/gestion-materias',[GestionMateriasController::class, 'crearAsistencia'])->name('crearAsistencia')->middleware('permission:asistencia');
        Route::get('/gestion-materias-asistencia-id/{id}',[GestionMateriasController::class, 'asistenciaId'])->name('asistenciaId')->middleware('permission:asistencia');
        Route::get('/gestion-materias-asistencia-idCalculo/{id}',[GestionMateriasController::class, 'estadisticaAsistencia'])->name('estadisticaAsistencia')->middleware('permission:asistencia');

        //estadoAlumno
        Route::get('/estadoAlumno/{id}',[EstadoAlumnoController::class,'index'])->name('estadoAlumnoIndex')->middleware('permission:asistencia-alumno');
        Route::put('/estado-cambio/{alumno_id}/{asistencia_id}',[EstadoAlumnoController::class,'cambiasEstado'])->name('cambiasEstadoAlumno')->middleware('permission:asistencia-alumno');

        //reportes
        Route::get('/reportes', [ReporteController::class,'index']);
        Route::get('/reportes/materia/{id}', [ReporteController::class,'materiaCatedratico'])->name('reporteMateria');
        Route::get('/reportes/materia/catedratico/estadoAlumno/{id}',[ReporteController::class,'reporteMateriaCatedraticoAlumno'])->name('reporteMateriaCatedraticoAlumno');
        Route::get('/reportes/materia/catedratico/{user_id}/{materia_id}', [ReporteController::class,'reporteMateriaCatedratico'])->name('reporteMateriaCatedratico');
        Route::get('/backup', [BackupController::class, 'create'])->name('backupCreate');
    });
});

