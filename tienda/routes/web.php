<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


//Admin
//Pelicula
Route::get('/admin/pelicula', [App\Http\Controllers\Admin\PeliculaController::class, 'index'])->name('admin.pelicula');
Route::post('/admin/pelicula/registro', [App\Http\Controllers\Admin\PeliculaController::class, 'registro'])->name('admin.pelicula.registro');
Route::post('/admin/pelicula/{peliculaId}/actualizar', [App\Http\Controllers\Admin\PeliculaController::class, 'actualizar'])->name('admin.pelicula.actualizar');
Route::delete('/admin/pelicula/{peliculaId}/eliminar', [App\Http\Controllers\Admin\PeliculaController::class, 'eliminar'])->name('admin.pelicula.eliminar');
Route::post('/admin/pelicula/{peliculaId}/cambiarEstado', [App\Http\Controllers\Admin\PeliculaController::class, 'cambiarEstado'])->name('admin.pelicula.cambiarEstado');

//Turnos
Route::get('/admin/turno', [App\Http\Controllers\Admin\TurnoController::class, 'index'])->name('admin.turno');
Route::post('/admin/turno/registro', [App\Http\Controllers\Admin\TurnoController::class, 'registro'])->name('admin.turno.registro');
Route::post('/admin/turno/{turnoId}/actualizar', [App\Http\Controllers\Admin\TurnoController::class, 'actualizar'])->name('admin.turno.actualizar');
Route::delete('/admin/turno/{turnoId}/eliminar', [App\Http\Controllers\Admin\TurnoController::class, 'eliminar'])->name('admin.turno.eliminar');
Route::post('/admin/turno/{turnoId}/cambiarEstado', [App\Http\Controllers\Admin\TurnoController::class, 'cambiarEstado'])->name('admin.turno.cambiarEstado');
