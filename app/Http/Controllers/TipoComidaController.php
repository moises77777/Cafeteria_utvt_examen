<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoComida;
use Illuminate\Http\Request;

// Controlador para gestión de tipos de comida - Implementa operaciones CRUD completas
class TipoComidaController extends Controller
{
    // Obtiene todos los registros de tb_tipo_comidas usando Eloquent y los pasa a la vista index
    // La vista mostrará una tabla con todos los tipos de comida registrados
    public function index()
    {
        $tiposComida = TipoComida::all();
        return view('tipo_comidas.index', compact('tiposComida'));
    }

    // Retorna la vista create.blade.php que contiene el formulario HTML vacío
    // El formulario enviará datos por POST al método store() para crear nuevos registros
    public function create()
    {
        return view('tipo_comidas.create');
    }

    // Procesa el formulario POST de creación, valida datos y guarda en tb_tipo_comidas
    // Usa validación Laravel para asegurar que el campo nombre_categoria sea requerido y esté en la lista
    // Redirige al listado con mensaje de éxito usando flash session
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|in:Bebidas,Postres,Platillos Fuertes,Entradas,Sopas,Entremeses,Pan'
        ]);

        TipoComida::create($request->all());
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida creado correctamente.');
    }

    // Busca un registro específico por ID usando findOrFail() que lanza 404 si no existe
    // Pasa el objeto a la vista show para mostrar detalles completos del tipo de comida
    public function show(string $id)
    {
        $tipoComida = TipoComida::findOrFail($id);
        return view('tipo_comidas.show', compact('tipoComida'));
    }

    // Busca el registro por ID y muestra el formulario edit.blade.php con datos precargados
    // El formulario permitirá modificar el nombre de la categoría existente
    public function edit(string $id)
    {
        $tipoComida = TipoComida::findOrFail($id);
        return view('tipo_comidas.edit', compact('tipoComida'));
    }

    // Procesa el formulario PUT/PATCH de actualización, valida y modifica el registro existente
    // Busca el registro por ID, aplica los cambios y redirige con mensaje de confirmación
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|in:Bebidas,Postres,Platillos Fuertes,Entradas,Sopas,Entremeses,Pan'
        ]);

        $tipoComida = TipoComida::findOrFail($id);
        $tipoComida->update($request->all());
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida actualizado correctamente.');
    }

    // Elimina un registro de tb_tipo_comidas después de verificar integridad referencial
    // Primero consulta si hay comidas asociadas usando la relación hasMany()
    // Si hay comidas dependientes, cancela la eliminación y muestra error
    // Si no hay dependencias, procede a eliminar el registro permanentemente
    public function destroy(string $id)   {
        $tipoComida = TipoComida::findOrFail($id);
        
        // Verifica si tiene comidas asociadas antes de eliminar para mantener integridad
        if ($tipoComida->comidas()->count() > 0) {
            return redirect()->route('tipo_comidas.index')
                ->with('error', 'No se puede eliminar este tipo de comida porque tiene comidas asociadas.');
        }
        
        $tipoComida->delete();
        return redirect()->route('tipo_comidas.index')
            ->with('success', 'Tipo de comida eliminado correctamente.');
    }
}
