@extends('layout')

@section('title', 'Ver Tipo de Comida - Cafetería UTV')

@section('content')
<div class="card">
    <h1>Detalles del Tipo de Comida</h1>

    <div class="form-group">
        <label>ID:</label>
        <p>{{ $tipoComida->id_tipo_comida }}</p>
    </div>

    <div class="form-group">
        <label>Categoría:</label>
        <p>{{ $tipoComida->nombre_categoria }}</p>
    </div>

    <div class="form-group">
        <label>Creado:</label>
        <p>{{ $tipoComida->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="form-group">
        <label>Actualizado:</label>
        <p>{{ $tipoComida->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="form-group">
        <a href="{{ route('tipo_comidas.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('tipo_comidas.edit', $tipoComida->id_tipo_comida) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
