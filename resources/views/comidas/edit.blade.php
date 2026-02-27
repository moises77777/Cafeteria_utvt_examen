@extends('layout')

@section('title', 'Editar Comida - Cafetería UTV')

@section('content')
<div class="card">
    <h1>Editar Comida</h1>

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('comidas.update', $comida->id_comida) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre_comida">Nombre de la Comida:</label>
            <input type="text" name="nombre_comida" id="nombre_comida" value="{{ old('nombre_comida', $comida->nombre_comida) }}" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="costo">Costo ($):</label>
            <input type="number" name="costo" id="costo" value="{{ old('costo', $comida->costo) }}" required min="0" step="0.01">
        </div>

        <div class="form-group">
            <label for="detalle_comida">Detalle:</label>
            <textarea name="detalle_comida" id="detalle_comida" rows="4" required>{{ old('detalle_comida', $comida->detalle_comida) }}</textarea>
        </div>

        <div class="form-group">
            <label for="id_tipo_comida">Tipo de Comida:</label>
            <select name="id_tipo_comida" id="id_tipo_comida" required>
                <option value="">Seleccione un tipo</option>
                @foreach($tiposComida as $tipo)
                    <option value="{{ $tipo->id_tipo_comida }}" {{ old('id_tipo_comida', $comida->id_tipo_comida) == $tipo->id_tipo_comida ? 'selected' : '' }}>
                        {{ $tipo->nombre_categoria }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <a href="{{ route('comidas.index') }}" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>
</div>
@endsection
