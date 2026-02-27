<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * ARCHIVO DE RUTAS: web.php
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * ¿Qué son las Rutas?
 * Las rutas conectan URLs con Controladores. Son como el "directorio" de la app
 * que dice: "Si el usuario va a esta URL, ejecuta este controlador".
 * 
 * EJEMPLO:
 * Route::get('/tipo_comidas', [TipoComidaController::class, 'index'])
 * URL: http://tusitio.com/tipo_comidas → Ejecuta TipoComidaController@index
 * 
 * ═══════════════════════════════════════════════════════════════════════════════
 * ROUTE::RESOURCE - EL ATAJO PARA CRUD
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * En lugar de definir 7 rutas manualmente, Route::resource() crea todas
 * las rutas necesarias para un CRUD completo:
 * 
 * MÉTODO   URL                         CONTROLADOR@MÉTODO    NOMBRE DE RUTA
 * ─────────────────────────────────────────────────────────────────────────
 * GET      /tipo_comidas               index()               tipo_comidas.index
 * GET      /tipo_comidas/create        create()              tipo_comidas.create
 * POST     /tipo_comidas               store()               tipo_comidas.store
 * GET      /tipo_comidas/{id}          show()                tipo_comidas.show
 * GET      /tipo_comidas/{id}/edit     edit()                tipo_comidas.edit
 * PUT      /tipo_comidas/{id}          update()              tipo_comidas.update
 * DELETE   /tipo_comidas/{id}          destroy()             tipo_comidas.destroy
 * 
 * PARÁMETRO {id}:
 * Es dinámico. Laravel extrae el número de la URL y lo pasa al controlador.
 * Ejemplo: /tipo_comidas/5 → $id = 5 en el controlador
 * 
 * COMANDO ÚTIL: php artisan route:list
 * Muestra todas las rutas registradas en la aplicación
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoComidaController;
use App\Http\Controllers\ComidaController;

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * RUTA RAÍZ (Home)
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Cuando alguien entra a http://tusitio.com/ sin especificar ruta,
 * redirigimos automáticamente al listado de tipos de comida.
 * 
 * redirect()->route('tipo_comidas.index'):
 * En lugar de redirigir a una URL hardcodeada, usamos el nombre de la ruta.
 * Esto es mejor porque si cambia la URL, la redirección sigue funcionando.
 */
Route::get('/', function () {
    return redirect()->route('tipo_comidas.index');
});

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * RUTAS RESOURCE PARA TIPO_COMIDAS
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Crea automáticamente las 7 rutas del CRUD para tipos de comida.
 * 
 * TipoComidaController::class le dice a Laravel qué controlador usar.
 */
Route::resource('tipo_comidas', TipoComidaController::class);

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * RUTAS RESOURCE PARA COMIDAS
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Igual que arriba pero para el controlador de Comidas.
 */
Route::resource('comidas', ComidaController::class);

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * EJEMPLOS DE RUTAS MANUALES (por si necesitas algo más específico)
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * // Ruta básica con función anónima (closure)
 * Route::get('/hola', function () {
 *     return 'Hola Mundo';
 * });
 * 
 * // Ruta con parámetro obligatorio
 * Route::get('/comida/{id}', function ($id) {
 *     return "Mostrando comida: $id";
 * });
 * 
 * // Ruta con parámetro opcional (usa ?)
 * Route::get('/comida/{id?}', function ($id = null) {
 *     return $id ? "Comida $id" : "Todas las comidas";
 * });
 * 
 * // Ruta con restricción (solo números)
 * Route::get('/comida/{id}', function ($id) {
 *     return "Comida $id";
 * })->where('id', '[0-9]+');
 */
