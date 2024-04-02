<?php
use App\Http\Controllers\ControllerConsultante;
use App\Http\Controllers\ControllerNuevoEmpleado;
use App\Http\Controllers\CRUDControlMasivo;
use App\Http\Controllers\CRUDCredito;
use App\Http\Controllers\CRUDAdmin;
use App\Http\Controllers\CRUDCoordinador;
use App\Http\Controllers\CRUDThumano;
use App\Http\Controllers\CRUDJefatura;
use App\Http\Controllers\CRUDGerencia;
use App\Http\Controllers\CRUDCoordinacion;
use App\Http\Controllers\ViewControl;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Mail\EnviarCorreo2;


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


//LOGIN
Route::get('inicia-sesion', [SessionsController::class, 'login'])
    //->middleware('guest')
    ->name('login.index');

Route::post('inicia-sesion', [SessionsController::class, 'login_post'])
    ->name('login');

Route::get('logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('login.destroy');


//ADMIN

Route::get('admin', [CRUDAdmin::class, 'view'])
    ->middleware('auth.admin')
    ->name('crud.list');

Route::get('admin/datatable', [CRUDAdmin::class, 'data'])
    ->middleware('auth.admin')
    ->name('datatable.admin');

Route::get('admin/datatable2', [CRUDAdmin::class, 'data2'])
    ->middleware('auth.admin')
    ->name('datatable2.admin');


Route::get('admineliminadoa', [CRUDAdmin::class, 'view2'])
    ->middleware('auth.admin')
    ->name('crud.list2');


Route::get('admineliminadoe', [CRUDAdmin::class, 'view4'])
    ->middleware('auth.admin')
    ->name('crud.list4');

Route::get('admineliminadop', [CRUDAdmin::class, 'view5'])
    ->middleware('auth.admin')
    ->name('crud.list5');

Route::get('adminproveedor', [CRUDAdmin::class, 'view6'])
    ->middleware('auth.admin')
    ->name('crud.list6');

Route::get('admineliminadoe/datatable', [CRUDAdmin::class, 'data4'])
    ->middleware('auth.admin')
    ->name('datatable4.admin');

Route::get('admineliminadop/datatable', [CRUDAdmin::class, 'data5'])
    ->middleware('auth.admin')
    ->name('datatable5.admin');

Route::get('adminproveedor/datatable', [CRUDAdmin::class, 'data6'])
    ->middleware('auth.admin')
    ->name('datatable.proveedora');

Route::post('adminproveedor/crear', [CRUDAdmin::class, 'create3'])
    ->name('cruda.createproveedor');

Route::post('adminproveedor/modificar_persona-{id}', [ControllerConsultante::class, 'update3'])
    ->name('cruda.modificarproveedor');

Route::get('admineliminadoe/eliminar_persona-{id}', [CRUDAdmin::class, 'delete3'])
    ->name('crud.delete3');

Route::get('admineliminadop/eliminar_persona-{id}', [CRUDAdmin::class, 'delete4'])
    ->name('crud.delete4');

Route::post('admin/crear', [CRUDAdmin::class, 'create'])
    ->name('crud.create');


Route::post('admin/modificar_persona-{id}', [CRUDAdmin::class, 'update'])
    ->name('crud.update');


Route::get('admin/eliminar_persona-{id}', [CRUDAdmin::class, 'delete'])
    ->name('crud.delete');



Route::get('admin/desactivar_persona-{id}', [CRUDAdmin::class, 'delete2'])
    ->name('crud.deactivate');

Route::get('admin/activar_persona-{id}', [CRUDAdmin::class, 'activate'])
    ->name('crud.activate');


Route::post('admin', [CRUDAdmin::class, 'list2'])
    ->name('rol.list');

Route::post('admin/registrar_rol', [CRUDAdmin::class, 'store'])
    ->name('rol.store');

Route::get('admin/email/{id}', [CRUDAdmin::class, 'verifyEmail'])->name('verification.verify');



Route::get('admin/activo-{id}', [CRUDAdmin::class, 'activo'])
    ->name('rol.activo');

Route::get('admin/desactivar-{id}', [CRUDAdmin::class, 'desactivar'])
    ->name('rol.desactivar');


Route::get('admin/eliminar_rol-{id}', [CRUDAdmin::class, 'eliminarRol'])
    ->name('rol.delete');


Route::post('admin/modificar_fechareporte-{id}', [CRUDAdmin::class, 'updateFechaReporte'])
    ->name('crud.updateFechaReporte');

//empleado admin
Route::get('adminempleado', [CRUDAdmin::class, 'view3'])
    ->middleware('auth.admin')
    ->name('crud.list3');


Route::get('adminempleado/datatable', [CRUDAdmin::class, 'data3'])
    ->middleware('auth.admin')
    ->name('datatable.data3');

Route::post('adminempleado/crear', [CRUDAdmin::class, 'create2'])
    ->name('cruda.create2');

Route::post('adminempleado/modificar-{id}', [CRUDAdmin::class, 'update2'])
    ->name('cruda.update2');


Route::get('admineliminadoa/eliminarp', [CRUDAdmin::class, 'eliminarTotal'])
    ->name('eliminar.total');

Route::get('admineliminadop/eliminarpro', [CRUDAdmin::class, 'eliminarTotalPro'])
    ->name('eliminar.totalPro');

Route::get('adminpagare', function () {
    return view('Admin/pagare');
})->middleware('auth.admin');


Route::get('adminpagare/datatable', [CRUDAdmin::class, 'data7'])
    ->middleware('auth.admin')
    ->name('datatable.data7');





//GENERADOR DE CONSULTAS ASOCIADOS
Route::get('coordinador', function () {
    return view('Coordinador/coordinador');
})->middleware('auth.asociacion');


Route::get('coordinador/datatable', [CRUDCoordinador::class, 'data'])
    ->middleware('auth.asociacion')
    ->name('datatable.coordinador');


Route::post('coordinador/modificar_persona-{id}', [CRUDCoordinador::class, 'update'])
    ->name('crud2.update');

Route::get('coordinador/eliminar_persona-{id}', [CRUDCoordinador::class, 'delete2'])
    ->name('crud.deactivate2');



Route::get('coordinadorcredito/eliminar_persona-{id}', [CRUDCoordinador::class, 'delete3'])
    ->name('crud2.deactivate2');


Route::get('coordinadorcredito', function () {
    return view('Coordinador/credito');
})->middleware('auth.asociacion');

Route::get('coordinadorcredito/datatable', [CRUDCoordinador::class, 'data2'])
    ->middleware('auth.asociacion')
    ->name('datatable.coordinadorcredito');

Route::post('coordinadorcredito/modificar{id}', [CRUDCoordinador::class, 'updatecredito'])
    ->name('crud.updatecreditoo');

//CREDITO
Route::get('credito', function () {
    return view('Credito/credito');
})->middleware('auth.credito');


Route::get('credito/datatable', [CRUDCredito::class, 'data'])
    ->middleware('auth.credito')
    ->name('datatable.credito');

Route::post('credito/modificar{id}', [CRUDCredito::class, 'update']);



//DIRECTOR DE AGENCIA

Route::middleware('auth.consultante')->group(function () {
    Route::get('director', function () {
        return view('Consultante/insertarconsultante');
    });

    Route::get('directorconsultar', [ControllerConsultante::class, 'listar'])->name('consultante.listar');
    Route::get('directorconsultare', function () {
        return view('Consultante/consultarempleado');
    });

    Route::get('directorconsultare/datatable', [ControllerConsultante::class, 'data5'])->name('datatable.consultante5');
    Route::get('directorconsultare/imprimir-{id}', [ControllerConsultante::class, 'imprimir2'])->name('consultante.imprimir2');
    Route::get('directorconsultar/datatable', [ControllerConsultante::class, 'data'])->name('datatable.consultante');
    Route::get('directorconsultarp', function () {
        return view('Consultante/consultarproveedor');
    });

    Route::get('directorconsultarp/datatable', [ControllerConsultante::class, 'data6'])->name('datatable.consultante6');
    Route::get('directorconsultarp/imprimir-{id}', [ControllerConsultante::class, 'imprimir3'])->name('consultante.imprimir3');
    Route::post('director/crear', [ControllerConsultante::class, 'create'])->name('crud.create2');
    Route::get('director/imprimir-{id}', [ControllerConsultante::class, 'imprimir'])->name('consultante.imprimir');
    Route::post('director/actualizar-{id}', [ControllerConsultante::class, 'update'])->name('crud.update2');
    Route::get('directorempleado', function () {
        return view('Consultante/agregarempleado');
    });

    Route::get('descargar-{id}', function ($id) {
        return view('Consultante/descargarasociados', ['id' => $id]);
    });

    Route::get('director/datatable8/{id}', [ControllerConsultante::class, 'data8'])->name('datatable.documentos');
    Route::get('descargare-{id}', function ($id) {
        return view('Consultante/descargarempleado', ['id' => $id]);
    });

    Route::get('descargarp-{id}', function ($id) {
        return view('Consultante/descargarproveedor', ['id' => $id]);
    });

    Route::get('director/datatable10/{id}', [ControllerConsultante::class, 'data10'])->name('datatable.documentos3');
    Route::get('director/datatable9/{id}', [ControllerConsultante::class, 'data8'])->name('datatable.documentos2');
    Route::get('directorempleado/datatable', [ControllerConsultante::class, 'data3'])->name('datatable.cempleado');
    Route::post('directorempleado/crear', [ControllerConsultante::class, 'create2'])->name('crudc.create');
    Route::post('directorempleado/modificar-{id}', [ControllerConsultante::class, 'update2'])->name('crudc.update');
    Route::get('directorproveedor', function () {
        return view('Consultante/dirproveedor');
    });

    Route::get('directorproveedor/datatable', [ControllerConsultante::class, 'data4'])->name('datatable.directorproovedor');
    Route::post('directorproveedor/crear', [ControllerConsultante::class, 'create3'])->name('crudc.createproveedor');
    Route::post('directorproveedor/modificar-{id}', [ControllerConsultante::class, 'update3'])->name('crud.updateproveedor');
    Route::get('directorcredito', function () {
        return view('Consultante/credito');
    });

    Route::get('directorcredito/datatable', [ControllerConsultante::class, 'data2'])->name('datatable.directorcredito');
    Route::post('directorcredito/crear', [ControllerConsultante::class, 'createcredito'])->name('crudc.createcredito');
    Route::post('directorcredito/modificar-{id}', [ControllerConsultante::class, 'update4'])->name('crud.updatecredito');
    Route::get('directorcreditoempl', function () {
        return view('Consultante/creditoempleado');
    });

    Route::post('directorcreditoempl/crear', [ControllerConsultante::class, 'createcreditoe'])->name('crudc.createcreditoe');
    Route::get('directorcreditoempl/datatable', [ControllerConsultante::class, 'data7'])->name('datatable.directorcreditoe');
    Route::post('directorcreditoempl/modificar-{id}', [ControllerConsultante::class, 'update5'])->name('crud.updatecredito5');
    Route::get('consultarcredito', function () {
        return view('Consultante/consultarcredito');
    });
    Route::get('consultarcreditoempl', function () {
        return view('Consultante/consultarcreditoemple');
    });

    Route::get('registrarpagaredir', function () {
        return view('Consultante/registrarpagare');
    });

    Route::get('registrarpagaredir/datatable', [ControllerConsultante::class, 'data11'])->name('datatable.consultarpagaredir');
    Route::post('registrarpagaredir/crear', [ControllerConsultante::class, 'createpagare'])->name('cruddir.createpagare');
    Route::post('registrarpagaredir/REPORTE-PAGARE', [ControllerConsultante::class, 'generarpdf'])->name('cruddir.generarpdf');
    Route::get('registrarpagaredir/rechazados', [ControllerConsultante::class, 'data12'])->name('datatabledir.rechazados');
    Route::get('registrarpagaredir/aprobado', [ControllerConsultante::class, 'data13'])->name('datatabledir.aprobados');
    Route::get('registrarpagaredir/pendientes', [ControllerConsultante::class, 'data14'])->name('datatabledir.pendientes');
    Route::post('dirpagarefecha', [ControllerConsultante::class, 'FechaReporte'])->name('cruddir.FechaReporte');
    Route::post('registrarpagaredir/modificar/{id}', [ControllerConsultante::class, 'adjuntarAutorizacion'])->name('cruddir.adjuntarautorizacion');
    Route::get('dirpagarefiltrar', function () {
        return view('Consultante/filtrar');
    });

    Route::get('registrarpagareordinariodir', function () {
        return view('Consultante/registrarpagareordinario');
    });

    Route::get('registrarpagareordinariodir/datatable', [ControllerConsultante::class, 'data15'])->name('datatable.dirpagareordinario');
    Route::post('registrarpagareordinariodir/crear', [ControllerConsultante::class, 'createpagareordinario'])->name('cruddir.createpagareordinario');

    Route::get('pruebas', function () {
        return view('Consultante/prueba');
    });

    Route::get('director/prueba/datatable', [ControllerConsultante::class, 'datosPagare'])
        ->name('datatable.prueba2');

    Route::get('solicitud', function () {
        return view('Consultante/solicitarautorizacion');
    });

    Route::get('solicitud', [ControllerConsultante::class, 'data16']);

});



//TALENTO HUMANO

Route::get('thumano', function () {
    return view('Thumano/thumano');
})->middleware('auth.thumano');

Route::get('thumano/datatable', [CRUDThumano::class, 'data'])
    ->middleware('auth.thumano')
    ->name('datatable.thumano');



Route::post('thumano/crear', [CRUDThumano::class, 'create'])
    ->name('crudt.create');

Route::post('thumano/modificar-{id}', [CRUDThumano::class, 'update'])
    ->name('crudt.update');

Route::get('thumanocredito', function () {
    return view('Thumano/creditoempleado');
})->middleware('auth.thumano');





Route::get('thproveedor', function () {
    return view('Thumano/thproveedor');
});

Route::get('thproveedor/datatable2', [CRUDThumano::class, 'data2'])
    ->middleware('auth.thumano')
    ->name('datatable.tproveedor');


Route::post('thproveedor/modificar{id}', [CRUDThumano::class, 'update3'])
    ->name('crudt.update3');



//CONTROL DATACREDITO
Route::get('control', function () {
    return view('Control/control');
});

Route::get('control/datatable', [ViewControl::class, 'data'])
    ->middleware('auth.control')
    ->name('datatableaso.control');

Route::get('creditocontrol', function () {
    return view('Control/creditocontrol');
});

Route::get('creditocontrol/datatable2', [ViewControl::class, 'data2'])
    ->middleware('auth.control')
    ->name('datatablecre.control');

Route::get('empleadocontrol', function () {
    return view('Control/empleadocontrol');
});

Route::get('empleadocontrol/datatable3', [ViewControl::class, 'data3'])
    ->middleware('auth.control')
    ->name('datatableemp.control');

Route::get('proveedorcontrol', function () {
    return view('Control/proveedorcontrol');
});

Route::get('proveedorcontrol/datatable', [ViewControl::class, 'data4'])
    ->middleware('auth.control')
    ->name('datatableprov.control');

//NUEVO EMPLEADOS
Route::get('nuevosempleados', function () {
    return view('NuevosEmpleados/nuevoempleado');
})->middleware('auth.nuevoempleado');


Route::get('nuevosempleados/datatable', [ControllerNuevoEmpleado::class, 'data'])
    ->middleware('auth.nuevoempleado')
    ->name('datatable.nuevoempleado');



Route::post('nuevosempleados/crear', [ControllerNuevoEmpleado::class, 'create'])
    ->name('crudnuevo.create');


Route::post('nuevosempleados/modificar{id}', [ControllerNuevoEmpleado::class, 'update'])
    ->name('crudnuevo.update');


Route::get('nuevosempleadosconsultar', function () {
    return view('NuevosEmpleados/consultarnuevoempleado');
})->middleware('auth.nuevoempleado');


Route::get('nuevosempleadosconsultar/imprimir-{id}', [ControllerNuevoEmpleado::class, 'imprimir'])
    ->name('imprimir.nuevoempleado');

Route::get('nuevosempleadosconsultar/datatable', [ControllerNuevoEmpleado::class, 'data2'])
    ->middleware('auth.nuevoempleado')
    ->name('datatable.nuevoempleado2');



Route::get('proveedortah', function () {
    return view('NuevosEmpleados/agregarprov');
})->middleware('auth.nuevoempleado');

Route::get('proveedortah/datatable', [ControllerNuevoEmpleado::class, 'data3'])
    ->middleware('auth.nuevoempleado')
    ->name('datatable.proveedortah');

Route::post('proveedortah/crear', [ControllerNuevoEmpleado::class, 'createprov'])
    ->name('crudnuevo.createproveedor');


Route::post('proveedortah/modificar{id}', [ControllerNuevoEmpleado::class, 'updateprov'])
    ->name('crudnuevo.update');

Route::get('consultarprovtah', function () {
    return view('NuevosEmpleados/consultarproveedor');
})->middleware('auth.nuevoempleado');

Route::get('consultarprovconsult/datatable', [ControllerNuevoEmpleado::class, 'data4'])
    ->middleware('auth.nuevoempleado')
    ->name('datatable.solicitudprov');

//GERENCIA
Route::get('gerenciaproveedor', function () {
    return view('Gerencia/gerencia');
})->middleware('auth.gerencia');



Route::get('gerenciaproveedor/datatable', [CRUDGerencia::class, 'data'])
    ->middleware('auth.gerencia')
    ->name('datatable.gerencia');

Route::post('gerenciaproveedor/crear', [CRUDGerencia::class, 'create'])
    ->name('crudger.createproveedor');


Route::post('gerenciaproveedor/modificar{id}', [CRUDGerencia::class, 'update'])
    ->name('crudger.update');

Route::get('consultarproveedorger', function () {
    return view('Gerencia/consultarproveedorger');
})->middleware('auth.gerencia');

Route::get('consultarproveedorger/datatable', [CRUDGerencia::class, 'data2'])
    ->middleware('auth.gerencia')
    ->name('datatable.consultarproveger');


//COORDINACION
Route::get('coordinacion', function () {
    return view('Coordinacion/coordinacion');
})->middleware('auth.coordinacion');

Route::get('coordinacion/datatable', [CRUDCoordinacion::class, 'data'])
    ->middleware('auth.coordinacion')
    ->name('datatable.proveedorcoordi');

Route::post('coordinacion/crear', [CRUDCoordinacion::class, 'create'])
    ->name('crudcoord.createproveedor');


Route::post('coordinacion/modificar{id}', [CRUDCoordinacion::class, 'update'])
    ->name('crudcoor.update');

Route::get('consultarprovc', function () {
    return view('Coordinacion/consultarproveedor');
})->middleware('auth.coordinacion');

Route::get('consultarprovc/datatable', [CRUDCoordinacion::class, 'data2'])
    ->middleware('auth.coordinacion')
    ->name('datatable.coordiproveconsulta');

Route::get('coorpagare', function () {
    return view('Coordinacion/pagare');
})->middleware('auth.coordinacion');

Route::get('coorpagare/datatable', [CRUDCoordinacion::class, 'data3'])
    ->middleware('auth.coordinacion')
    ->name('datatable.coordipagare');

Route::get('registrarpagare', function () {
    return view('Coordinacion/registrarpagare');
})->middleware('auth.coordinacion');

Route::get('registrarpagare/datatable', [CRUDCoordinacion::class, 'data4'])
    ->middleware('auth.coordinacion')
    ->name('datatable.consultarpagareger');

Route::post('registrarpagare/crear', [CRUDCoordinacion::class, 'createpagare'])
    ->name('crudger.createpagare');



Route::get('registrarpagare/rechazados', [CRUDCoordinacion::class, 'data5'])
    ->middleware('auth.coordinacion')
    ->name('datatable.rechazados');

Route::get('registrarpagare/aprobado', [CRUDCoordinacion::class, 'data6'])
    ->middleware('auth.coordinacion')
    ->name('datatable.aprobados');

Route::get('registrarpagare/pendientes', [CRUDCoordinacion::class, 'data7'])
    ->middleware('auth.coordinacion')
    ->name('datatable.pendientes');

Route::post('coorpagarefecha', [CRUDCoordinacion::class, 'FechaReporte'])
    ->middleware('auth.coordinacion')
    ->name('crudcoord.FechaReporte');

Route::post('registrarpagare/modificar/{id}', [CRUDCoordinacion::class, 'adjuntarAutorizacion'])
    ->name('crudger.adjuntarautorizacion');



Route::get('coorpagarefiltrar', function () {
    return view('Coordinacion/filtrar');
})->middleware('auth.coordinacion');


Route::get('registrarpagare/pendientes', [CRUDCoordinacion::class, 'data6'])
    ->middleware('auth.coordinacion')
    ->name('datatable.pendientes');


Route::get('registrarpagareordinario', function () {
    return view('Coordinacion/registrarpagareordinario');
})->middleware('auth.coordinacion');


Route::get('pagarecorreos', function () {
    return view('Coordinacion/pagarecorreos');
})->middleware('auth.coordinacion');

Route::get('pagarecorreos/datatable', [CRUDCoordinacion::class, 'data8'])
    ->middleware('auth.coordinacion')
    ->name('datatable.coordipagarecorreos');


Route::get('pagarecorreos/{id}', [CRUDCoordinacion::class, 'updateaprobado'])
    ->name('crud.pagarecorreo');


Route::get('pagarecorreosrecha/{id}', [CRUDCoordinacion::class, 'updatearechazado'])
    ->name('crud.pagarecorreorecha');


Route::post('registrarpagareordinario/crear', [CRUDCoordinacion::class, 'createpagareordinario'])
    ->name('crudger.createpagareordinario');

Route::get('registrarpagareordinario/datatable', [CRUDCoordinacion::class, 'data9'])
    ->middleware('auth.coordinacion')
    ->name('datatable.ordinarios');

Route::post('registrarpagare/REPORTE-ASEGURABILIDAD', [CRUDCoordinacion::class, 'asegurabilidad'])
    ->name('crudcor.asegurabilidad');

Route::post('registrarpagare/REPORTE-PAGARE', [CRUDCoordinacion::class, 'generarpdf'])
    ->name('crudger.generarpdf');

Route::post('registrarpagare/asegurabilidad/{id}', [CRUDCoordinacion::class, 'adjuntarAsegurabilidad'])
    ->name('crudcor.adjuntarasegurabilidad');

Route::get('prueba', function () {
    return view('Coordinacion/prueba');
})->middleware('auth.coordinacion');

Route::get('prueba/datatable', [CRUDCoordinacion::class, 'datosPagare'])
    ->middleware('auth.coordinacion')
    ->name('datatable.prueba');

Route::get('info/datatable', [CRUDCoordinacion::class, 'data10'])
    ->middleware('auth.coordinacion')
    ->name('datatable.info');

Route::get('coordinacion/aprobar{id}', [CRUDCoordinacion::class, 'aprobarCredito'])
    ->name('crudcoor.aprobarcred');

Route::get('coordinacion/rechazar{id}', [CRUDCoordinacion::class, 'rechazarCredito'])
    ->name('crudcoor.rechazarcred');

Route::get('coordinacionconsultarp/imprimir-{id}', [CRUDCoordinacion::class, 'imprimir3'])->name('coordinadorr.imprimir3');



//JEFATURAS

Route::get('jefaturaproveedor', function () {
    return view('Jefatura/jefatura');
})->middleware('auth.jefatura');

Route::get('jefaturaproveedor/datatable', [CRUDJefatura::class, 'data'])
    ->middleware('auth.jefatura')
    ->name('datatable.proveedorjefa');

Route::post('jefaturaproveedor/crear', [CRUDJefatura::class, 'create'])
    ->name('crudjefa.createproveedor');


Route::post('jefaturaproveedor/modificar{id}', [CRUDJefatura::class, 'update'])
    ->name('crudjef.update');

Route::get('consultarproveedor', function () {
    return view('Jefatura/consultarproveedor');
})->middleware('auth.jefatura');

Route::get('consultarproveedor2/datatable', [CRUDJefatura::class, 'data2'])
    ->middleware('auth.jefatura')
    ->name('datatable.consultanteprove');


//CONTROL MASIVO
Route::get('controlmasivoproveedor', function () {
    return view('ControlMasivo/agregarproveedor');
})->middleware('auth.controlmasivo');

Route::get('controlmasivoproveedor/datatable', [CRUDControlMasivo::class, 'data'])
    ->middleware('auth.controlmasivo')
    ->name('datatable.proveedormasivo');

Route::post('controlmasivo/crear', [CRUDControlMasivo::class, 'create'])
    ->name('crudmasivo.createproveedor');


Route::post('controlmasivo/modificar{id}', [CRUDControlMasivo::class, 'update'])
    ->name('crudmasivo.update');

Route::get('consultarproveedormas', function () {
    return view('ControlMasivo/consultarproveedor');
})->middleware('auth.controlmasivo');

Route::get('consultarproveedormas/datatable', [CRUDControlMasivo::class, 'data2'])
    ->middleware('auth.controlmasivo')
    ->name('datatable.consultanteprov');

//
Route::get('controlmasivo', function () {
    return view('ControlMasivo/control');
});

Route::get('controlmasivo/datatable', [CRUDControlMasivo::class, 'data3'])
    ->middleware('auth.controlmasivo')
    ->name('datatableaso.controlmasivo');

Route::get('creditocontrolmasivo', function () {
    return view('ControlMasivo/creditocontrol');
});

Route::get('creditocontrolmasivo/datatable2', [CRUDControlMasivo::class, 'data4'])
    ->middleware('auth.controlmasivo')
    ->name('datatablecre.controlmasivo');

Route::get('empleadocontrolmasivo', function () {
    return view('ControlMasivo/empleadocontrol');
});

Route::get('empleadocontrolmasivo/datatable3', [CRUDControlMasivo::class, 'data5'])
    ->middleware('auth.controlmasivo')
    ->name('datatableemp.controlmasivo');

Route::get('proveedorcontrolmasivo', function () {
    return view('ControlMasivo/proveedorcontrol');
});

Route::get('proveedorcontrolmasivo/datatable', [CRUDControlMasivo::class, 'data6'])
    ->middleware('auth.controlmasivo')
    ->name('datatableprov.controlmasivo');








