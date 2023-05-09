<?php
use App\Http\Controllers\ControllerConsultante;
use App\Http\Controllers\CRUDCredito;
use App\Http\Controllers\CRUDAdmin;
use App\Http\Controllers\CRUDAsociacion;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('index', function () {
    return view('index');
});
//CONSULTANTE
Route::get('consultante', [ControllerConsultante::class, 'listar'])
->name('consultante.listar');

Route::get('consultante/imprimir-{id}', [ControllerConsultante::class, 'imprimir'])
->name('consultante.imprimir');




//ADMIN
Route::get('datacredito', [CRUDAdmin::class, 'list'])
->name('crud.list');


Route::post('datacredito/crear', [CRUDAdmin::class, 'create'])
->name('crud.create');


Route::post('datacredito/modificar_persona-{id}', [CRUDAdmin::class, 'update'])
->name('crud.update');


Route::get('datacredito/eliminar_persona-{id}', [CRUDAdmin::class, 'delete'])
->name('crud.delete');


Route::post('datacredito', [CRUDAdmin::class, 'list2'])
->name('rol.list');

Route::post('datacredito/registrar_rol', [CRUDAdmin::class, 'store'])
->name('rol.store');


Route::get('datacredito/activo-{id}', [CRUDAdmin::class, 'activo'])
->name('rol.activo');

Route::get('datacredito/desactivar-{id}', [CRUDAdmin::class, 'desactivar'])
->name('rol.desactivar');


Route::get('datacredito/eliminar_rol-{id}', [CRUDAdmin::class, 'eliminarRol'])
->name('rol.delete');


//LOGIN
Route::get('inicia-sesion', [SessionsController::class, 'login'])
->middleware('guest')
->name('login.index');

Route::post('inicia-sesion', [SessionsController::class, 'store'])
->name('login.store');

Route::get('logout', [SessionsController::class, 'destroy'])
->middleware('auth')
->name('login.destroy');





//ASOCIACION
Route::get('asociacion', [CRUDAsociacion::class, 'list'])->name('crud2.list');
// ->middleware('auth.admin')
// ->name('crud.list');


Route::post('asociacion/registrar_persona', [CRUDAsociacion::class, 'create'])
->name('crud2.create');


Route::post('asociacion/modificar_persona-{id}', [CRUDAsociacion::class, 'update'])
->name('crud2.update');


Route::get('asociacion/eliminar_persona-{id}', [CRUDAsociacion::class, 'delete'])
->name('crud2.delete');




//CREDITO

Route::get('credito', [CRUDCredito::class, 'list'])->name('crud3.list');
// ->middleware('auth.admin')
// ->name('crud.list');


Route::post('credito/registrar_persona', [CRUDCredito::class, 'create'])
->name('crud3.create');


Route::post('credito/modificar_persona-{id}', [CRUDCredito::class, 'update'])
->name('crud3.update');


Route::get('credito/eliminar_persona-{id}', [CRUDCredito::class, 'delete'])
->name('crud3.delete');
