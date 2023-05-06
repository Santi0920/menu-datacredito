<?php
use App\Http\Controllers\ControllerConsultante;
use App\Http\Controllers\CRUDPersona;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::get('consultante', [ControllerConsultante::class, 'listar'])->name('consultante.listar');

Route::get('consultante/imprimir-{id}', [ControllerConsultante::class, 'imprimir'])->name('consultante.imprimir');

Route::get('datacredito', [CRUDPersona::class, 'list'])->name('crud.list');

//Ruta para registrar presona
Route::post('datacredito/registrar_persona', [CRUDPersona::class, 'create'])->name('crud.create');

//Ruta para modificar persona
Route::post('datacredito/modificar_persona-{id}', [CRUDPersona::class, 'update'])->name('crud.update');

//Ruta para eliminar presona
Route::get('datacredito/eliminar_persona-{id}', [CRUDPersona::class, 'delete'])->name('crud.delete');

