@extends('layout')

@section('title', 'Tipos de Comida - Cafetería UTV')

@section('content')
<div class="card">
    <div class="header-actions">
        <h1>Tipos de Comida</h1>
        <a href="{{ route('tipo_comidas.create') }}" class="btn btn-success">+ Nuevo Tipo</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tiposComida as $tipo)
            <tr>
                <td>{{ $tipo->id_tipo_comida }}</td>
                <td>{{ $tipo->nombre_categoria }}</td>
                <td>{{ $tipo->created_at->format('d/m/Y H:i') }}</td>
                <td class="actions">
                    <a href="{{ route('tipo_comidas.show', $tipo->id_tipo_comida) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('tipo_comidas.edit', $tipo->id_tipo_comida) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('tipo_comidas.destroy', $tipo->id_tipo_comida) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de comida?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">No hay tipos de comida registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
