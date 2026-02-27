@extends('layout')

@section('title', 'Comidas - Cafetería UTV')

@section('content')
<div class="card">
    <div class="header-actions">
        <h1>Comidas</h1>
        <a href="{{ route('comidas.create') }}" class="btn btn-success">+ Nueva Comida</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Costo</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comidas as $comida)
            <tr>
                <td>{{ $comida->id_comida }}</td>
                <td>{{ $comida->nombre_comida }}</td>
                <td>${{ number_format($comida->costo, 2) }}</td>
                <td>{{ $comida->tipoComida->nombre_categoria ?? 'N/A' }}</td>
                <td class="actions">
                    <a href="{{ route('comidas.show', $comida->id_comida) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('comidas.edit', $comida->id_comida) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('comidas.destroy', $comida->id_comida) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta comida?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">No hay comidas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
