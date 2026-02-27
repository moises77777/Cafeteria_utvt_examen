@extends('layout')

@section('title', 'Ver Comida - Cafetería UTV')

@section('content')
<div class="card">
    <h1>Detalles de la Comida</h1>

    <div class="form-group">
        <label>ID:</label>
        <p>{{ $comida->id_comida }}</p>
    </div>

    <div class="form-group">
        <label>Nombre:</label>
        <p>{{ $comida->nombre_comida }}</p>
    </div>

    <div class="form-group">
        <label>Costo:</label>
        <p>${{ number_format($comida->costo, 2) }}</p>
    </div>

    <div class="form-group">
        <label>Detalle:</label>
        <p>{{ $comida->detalle_comida }}</p>
    </div>

    <div class="form-group">
        <label>Tipo de Comida:</label>
        <p>{{ $comida->tipoComida->nombre_categoria ?? 'N/A' }}</p>
    </div>

    <div class="form-group">
        <label>Creado:</label>
        <p>{{ $comida->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="form-group">
        <label>Actualizado:</label>
        <p>{{ $comida->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="form-group">
        <a href="{{ route('comidas.index') }}" class="btn btn-primary">Volver</a>
        <a href="{{ route('comidas.edit', $comida->id_comida) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endsection
