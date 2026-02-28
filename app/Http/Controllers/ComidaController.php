<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comida;
use App\Models\TipoComida;
use Illuminate\Http\Request;

// Controlador para gestión de comidas con relación a tipos de comida - Maneja CRUD con relaciones
class ComidaController extends Controller
{
    // Obtiene todas las comidas usando eager loading con with() para optimizar rendimiento
    // Evita el problema N+1 queries cargando tipos de comida en una sola consulta SQL
    // Pasa la colección a la vista index para mostrar tabla con nombres de categorías
    public function index()
    {
        $comidas = Comida::with('tipoComida')->get();
        return view('comidas.index', compact('comidas'));
    }

    // Muestra formulario create.blade.php para nueva comida con dropdown de categorías
    // Obtiene todos los tipos de comida de tb_tipo_comidas para llenar el campo select
    // El usuario seleccionará a qué categoría pertenece la nueva comida
    public function create()
    {
        $tiposComida = TipoComida::all();
        return view('comidas.create', compact('tiposComida'));
    }

    // Procesa formulario POST de creación con validación múltiple de campos
    // Valida nombre (string), costo (numeric positivo), detalle (opcional), y tipo (existente)
    // La regla 'exists' verifica que id_tipo_comida exista en tb_tipo_comidas
    // Crea el registro con todos los campos validados usando mass assignment
    public function store(Request $request)
    {
        $request->validate([
            'nombre_comida' => 'required|string|max:100',
            'costo' => 'required|numeric|min:0',
            'detalle_comida' => 'nullable|string',
            'id_tipo_comida' => 'required|exists:tb_tipo_comidas,id_tipo_comida'
        ]);

        Comida::create($request->all());
        return redirect()->route('comidas.index')
            ->with('success', 'Comida creada correctamente.');
    }

    // Muestra vista show.blade.php con detalles completos de una comida específica
    // Usa eager loading para cargar también el nombre de la categoría relacionada
    // findOrFail() lanza excepción 404 si el ID no existe en la base de datos
    public function show(string $id)
    {
        $comida = Comida::with('tipoComida')->findOrFail($id);
        return view('comidas.show', compact('comida'));
    }

    // Muestra formulario edit.blade.php con datos actuales de la comida a modificar
    // Carga la comida específica y todos los tipos disponibles para el dropdown
    // El formulario viene precargado con los valores actuales del registro
    public function edit(string $id)
    {
        $comida = Comida::findOrFail($id);
        $tiposComida = TipoComida::all();
        return view('comidas.edit', compact('comida', 'tiposComida'));
    }

    // Procesa formulario PUT/PATCH de actualización con las mismas validaciones que store
    // Busca el registro existente, aplica los cambios validados y guarda en base de datos
    // Mantiene la integridad de la relación con el tipo de comida seleccionado
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_comida' => 'required|string|max:100',
            'costo' => 'required|numeric|min:0',
            'detalle_comida' => 'nullable|string',
            'id_tipo_comida' => 'required|exists:tb_tipo_comidas,id_tipo_comida'
        ]);

        $comida = Comida::findOrFail($id);
        $comida->update($request->all());
        return redirect()->route('comidas.index')
            ->with('success', 'Comida actualizada correctamente.');
    }

    // Elimina una comida específica de tb_comidas sin verificar dependencias
    // Las comidas no tienen tablas hijas, por lo que pueden eliminarse directamente
    // Usa delete() de Eloquent para eliminar permanentemente el registro
    public function destroy(string $id)
    {
        $comida = Comida::findOrFail($id);
        $comida->delete();
        return redirect()->route('comidas.index')
            ->with('success', 'Comida eliminada correctamente.');
    }
}
