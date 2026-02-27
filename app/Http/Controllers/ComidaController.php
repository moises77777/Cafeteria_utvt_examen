<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * CONTROLADOR: COMIDA CONTROLLER
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Este controlador maneja el CRUD de Comidas.
 * Es similar a TipoComidaController pero con una diferencia clave:
 * LAS COMIDAS DEPENDEN DE LOS TIPOS DE COMIDA (relación foreign key).
 * 
 * CONCEPTO CLAVE: EAGER LOADING (Carga Anticipada)
 * Usamos with('tipoComida') para cargar la relación en una sola consulta.
 * Esto evita el problema "N+1 queries" y mejora el rendimiento.
 * 
 * ¿Por qué necesitamos TipoComida en create() y edit()?
 * Para mostrar el dropdown de categorías disponibles en los formularios.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comida;
use App\Models\TipoComida;
use Illuminate\Http\Request;

class ComidaController extends Controller
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * INDEX - Listar todas las comidas
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * DIFERENCIA IMPORTANTE con TipoComida::all():
     * 
     * Usamos Comida::with('tipoComida')->get()
     * 
     * ¿Por qué?
     * - Comida tiene una relación con TipoComida (foreign key)
     * - Queremos mostrar el nombre de la categoría en la lista
     * - with() carga la relación en LA MISMA consulta SQL
     * 
     * SIN with(): Hace 1 consulta para comidas + N consultas para tipos
     * CON with(): Hace solo 2 consultas total (mucho más rápido)
     * 
     * SQL generado:
     * SELECT * FROM tb_comidas
     * SELECT * FROM tb_tipo_comidas WHERE id_tipo_comida IN (1,2,3...)
     */
    public function index()
    {
        $comidas = Comida::with('tipoComida')->get();
        return view('comidas.index', compact('comidas'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * CREATE - Mostrar formulario de creación
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * ¿Por qué necesitamos TipoComida::all() aquí?
     * 
     * El formulario de crear comida tiene un dropdown (select) para elegir
     * el tipo de comida (Bebida, Postre, etc.).
     * 
     * Necesitamos pasar todos los tipos disponibles a la vista
     * para que el usuario pueda seleccionar uno.
     * 
     * FLUJO:
     * 1. Consultamos todos los tipos de comida
     * 2. Los pasamos a la vista como $tiposComida
     * 3. La vista genera un <select> con esas opciones
     */
    public function create()
    {
        $tiposComida = TipoComida::all();
        return view('comidas.create', compact('tiposComida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * STORE - Guardar nueva comida en BD
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * VALIDACIONES EXPLICADAS:
     * 
     * 'nombre_comida' => 'required|string|max:100'
     * - required: Campo obligatorio
     * - string: Debe ser texto (no números solos)
     * - max:100: Máximo 100 caracteres (como definimos en la migración)
     * 
     * 'costo' => 'required|numeric|min:0'
     * - numeric: Debe ser un número (acepta decimales)
     * - min:0: No puede ser negativo
     * 
     * 'id_tipo_comida' => 'required|exists:tb_tipo_comidas,id_tipo_comida'
     * - exists: Verifica que el ID exista en la tabla tb_tipo_comidas
     * - INTEGRIDAD REFERENCIAL: Evita crear comidas con tipos inexistentes
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_comida' => 'required|string|max:100',
            'costo' => 'required|numeric|min:0',
            'detalle_comida' => 'required|string',
            'id_tipo_comida' => 'required|exists:tb_tipo_comidas,id_tipo_comida'
        ]);

        Comida::create($request->all());

        return redirect()->route('comidas.index')
            ->with('success', 'Comida creada exitosamente.');
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * SHOW - Ver detalles de una comida
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Igual que en index(), usamos with('tipoComida') para cargar
     * la relación y poder mostrar el nombre de la categoría.
     * 
     * Ejemplo en la vista:
     * {{ $comida->nombre_comida }} - Nombre de la comida
     * {{ $comida->tipoComida->nombre_categoria }} - Nombre del tipo
     */
    public function show(string $id)
    {
        $comida = Comida::with('tipoComida')->findOrFail($id);
        return view('comidas.show', compact('comida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * EDIT - Mostrar formulario de edición
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * ¿Por qué pasamos DOS variables a la vista?
     * 
     * 1. $comida - La comida que estamos editando (para llenar el formulario)
     * 2. $tiposComida - Todos los tipos disponibles (para el dropdown)
     * 
     * compact('comida', 'tiposComida') es equivalente a:
     * ['comida' => $comida, 'tiposComida' => $tiposComida]
     */
    public function edit(string $id)
    {
        $comida = Comida::findOrFail($id);
        $tiposComida = TipoComida::all();
        return view('comidas.edit', compact('comida', 'tiposComida'));
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * UPDATE - Guardar cambios de edición
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Mismo proceso que store() pero actualizando en lugar de crear.
     * Las validaciones son idénticas para mantener consistencia.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_comida' => 'required|string|max:100',
            'costo' => 'required|numeric|min:0',
            'detalle_comida' => 'required|string',
            'id_tipo_comida' => 'required|exists:tb_tipo_comidas,id_tipo_comida'
        ]);

        $comida = Comida::findOrFail($id);
        $comida->update($request->all());

        return redirect()->route('comidas.index')
            ->with('success', 'Comida actualizada exitosamente.');
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * DESTROY - Eliminar comida
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * NOTA: No verificamos relaciones aquí porque Comida es la tabla "hija"
     * (la que tiene la foreign key). 
     * 
     * En la tabla "padre" (TipoComida) sí verificamos porque eliminar un padre
     * dejaría huérfanos a los hijos. Eliminar un hijo no afecta al padre.
     */
    public function destroy(string $id)
    {
        $comida = Comida::findOrFail($id);
        $comida->delete();

        return redirect()->route('comidas.index')
            ->with('success', 'Comida eliminada exitosamente.');
    }
}
