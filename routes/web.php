<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoComidaController;
use App\Http\Controllers\ComidaController;

// Ruta principal del proyecto - Muestra página de bienvenida por defecto
// Se accede mediante GET a la URL raíz http://dominio.com/
Route::get('/', function () {
    return redirect()->route('tipo_comidas.index');
});

// Rutas resource automáticas que generan las 7 rutas CRUD estándar
// Route::resource() crea automáticamente: index, create, store, show, edit, update, destroy
// Evita definir cada ruta manualmente, siguiendo convención RESTful
Route::resource('tipo_comidas', TipoComidaController::class);
Route::resource('comidas', ComidaController::class);
