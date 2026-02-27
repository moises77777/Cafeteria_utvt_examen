<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * CONTROLADOR: TIPO COMIDA CONTROLLER
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * ¿Qué es un Controlador?
 * Un controlador es como el "mesero" de la aplicación. Recibe las peticiones del
 * usuario (como cuando haces clic en un botón), procesa la información hablando
 * con los Modelos (base de datos), y decide qué Vista mostrar.
 * 
 * PATRÓN MVC (Model-View-Controller):
 * - Modelo (M): Maneja los datos y la lógica de negocio (la BD)
 * - Vista (V): Muestra la interfaz al usuario (HTML/CSS)
 * - Controlador (C): Coordina entre el Modelo y la Vista
 * 
 * CRUD - Las 4 operaciones básicas:
 * C = Create (Crear)    → Métodos: create(), store()
 * R = Read (Leer)     → Métodos: index(), show()
 * U = Update (Actualizar) → Métodos: edit(), update()
 * D = Delete (Eliminar)   → Método: destroy()
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoComida;
use Illuminate\Http\Request;

class TipoComidaController extends Controller
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: INDEX (R de READ - Leer Todos)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: GET /tipo_comidas
     * 
     * ¿Qué hace?
     * Muestra una lista de TODOS los tipos de comida registrados.
     * Es como pedir "la carta completa" del restaurante.
     * 
     * TipoComida::all():
     * Consulta SQL equivalente: SELECT * FROM tb_tipo_comidas
     * 
     * compact('tiposComida'):
     * Envía la variable $tiposComida a la vista para que pueda usarla.
     */
    public function index()
    {
        // Consultamos TODOS los registros de la tabla
        $tiposComida = TipoComida::all();
        
        // Retornamos la vista 'tipo_comidas.index' pasándole los datos
        return view('tipo_comidas.index', compact('tiposComida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: CREATE (C de CREATE - Mostrar Formulario)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: GET /tipo_comidas/create
     * 
     * ¿Qué hace?
     * Muestra el FORMULARIO para crear un nuevo tipo de comida.
     * Solo muestra la vista, NO guarda nada todavía.
     * 
     * Por qué GET y no POST?
     * GET se usa para "pedir" información (mostrar formularios)
     * POST se usa para "enviar" información (guardar datos)
     */
    public function create()
    {
        return view('tipo_comidas.create');
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: STORE (C de CREATE - Guardar en BD)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: POST /tipo_comidas
     * 
     * ¿Qué hace?
     * Recibe los datos del formulario, los valida y los guarda en la BD.
     * 
     * FLUJO:
     * 1. Usuario llena formulario → clic en "Guardar"
     * 2. Navegador envía POST request a /tipo_comidas
     * 3. Laravel recibe datos en $request
     * 4. Validamos que los datos sean correctos
     * 5. Guardamos en la BD con TipoComida::create()
     * 6. Redirigimos al usuario con mensaje de éxito
     * 
     * VALIDACIÓN:
     * - required: El campo es obligatorio (no puede estar vacío)
     * - in:...: El valor debe ser uno de los permitidos en la lista
     */
    public function store(Request $request)
    {
        // VALIDACIÓN: Verificamos que los datos cumplan las reglas
        $request->validate([
            'nombre_categoria' => 'required|in:Bebidas,Postres,Platillos Fuertes,Entradas,Sopas'
        ]);

        // GUARDAR: Creamos el registro en la base de datos
        // TipoComida::create() usa asignación masiva (fillable)
        // $request->all() contiene todos los datos del formulario
        TipoComida::create($request->all());

        // REDIRECCIÓN: Volvemos al listado con mensaje de éxito
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida creado exitosamente.');
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: SHOW (R de READ - Ver Detalles de Uno)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: GET /tipo_comidas/{id}
     * 
     * ¿Qué hace?
     * Muestra los detalles de UN solo tipo de comida específico.
     * 
     * findOrFail($id):
     * - Busca el registro con ese ID
     * - Si lo encuentra: lo retorna
     * - Si NO lo encuentra: muestra error 404 automáticamente
     * 
     * Parámetro $id:
     * Laravel extrae automáticamente el número de la URL.
     * Ejemplo: /tipo_comidas/5 → $id = 5
     */
    public function show(string $id)
    {
        // Buscamos el registro o fallamos con 404 si no existe
        $tipoComida = TipoComida::findOrFail($id);
        
        // Mostramos la vista de detalles
        return view('tipo_comidas.show', compact('tipoComida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: EDIT (U de UPDATE - Mostrar Formulario de Edición)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: GET /tipo_comidas/{id}/edit
     * 
     * ¿Qué hace?
     * Muestra el formulario para editar un tipo de comida existente,
     * precargado con los datos actuales.
     * 
     * ¿Por qué tenemos create() y edit() separados?
     * - create(): Formulario VACÍO para crear nuevo
     * - edit(): Formulario con datos EXISTENTES para modificar
     */
    public function edit(string $id)
    {
        // Buscamos el registro a editar
        $tipoComida = TipoComida::findOrFail($id);
        
        // Mostramos el formulario con los datos actuales
        return view('tipo_comidas.edit', compact('tipoComida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: UPDATE (U de UPDATE - Guardar Cambios)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: PUT /tipo_comidas/{id}
     * 
     * ¿Qué hace?
     * Recibe los datos editados del formulario y actualiza el registro.
     * 
     * DIFERENCIA entre STORE y UPDATE:
     * - STORE: Crea un registro NUEVO (INSERT)
     * - UPDATE: Modifica un registro EXISTENTE (UPDATE SQL)
     * 
     * @method('PUT') en el formulario:
     * HTML solo soporta GET y POST, así que Laravel usa un truco:
     * - El formulario usa POST pero incluye @method('PUT')
     * - Laravel interpreta esto como PUT request
     */
    public function update(Request $request, string $id)
    {
        // Validamos los datos recibidos
        $request->validate([
            'nombre_categoria' => 'required|in:Bebidas,Postres,Platillos Fuertes,Entradas,Sopas'
        ]);

        // Buscamos el registro a actualizar
        $tipoComida = TipoComida::findOrFail($id);
        
        // Actualizamos con los nuevos datos
        $tipoComida->update($request->all());

        // Redirigimos con mensaje de éxito
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida actualizado exitosamente.');
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO: DESTROY (D de DELETE - Eliminar)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * URL: DELETE /tipo_comidas/{id}
     * 
     * ¿Qué hace?
     * Elimina un registro de la base de datos.
     * 
     * VALIDACIÓN DE INTEGRIDAD:
     * Antes de eliminar, verificamos que no tenga comidas relacionadas.
     * Esto evita "huerfanizar" registros en la otra tabla.
     * 
     * $tipoComida->comidas()->count():
     * Cuenta cuántas comidas están asociadas a este tipo.
     * Si hay comidas relacionadas, NO permitimos la eliminación.
     */
    public function destroy(string $id)
    {
        // Buscamos el registro a eliminar
        $tipoComida = TipoComida::findOrFail($id);
        
        // VALIDACIÓN DE INTEGRIDAD REFERENCIAL
        // Verificamos si tiene comidas relacionadas
        if ($tipoComida->comidas()->count() > 0) {
            // Si tiene relaciones, no permitimos eliminar
            return redirect()->route('tipo_comidas.index')
                ->with('error', 'No se puede eliminar el tipo de comida porque tiene comidas relacionadas.');
        }
        
        // ELIMINACIÓN: Borramos el registro de la BD
        $tipoComida->delete();

        // Redirigimos con mensaje de éxito
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida eliminado exitosamente.');
    }
}
