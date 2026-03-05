@extends('layout')

@section('title', 'Editar Tipo de Comida - Cafetería UTV')

@section('content')
<div class="card">
    <h1>Editar Tipo de Comida</h1>

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tipo_comidas.update', $tipoComida->id_tipo_comida) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre_categoria">Categoría:</label>
            <select name="nombre_categoria" id="nombre_categoria" required>
                <option value="">Seleccione una categoría</option>
                <option value="Bebidas" {{ $tipoComida->nombre_categoria == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                <option value="Postres" {{ $tipoComida->nombre_categoria == 'Postres' ? 'selected' : '' }}>Postres</option>
                <option value="Platillos Fuertes" {{ $tipoComida->nombre_categoria == 'Platillos Fuertes' ? 'selected' : '' }}>Platillos Fuertes</option>
                <option value="Entradas" {{ $tipoComida->nombre_categoria == 'Entradas' ? 'selected' : '' }}>Entradas</option>
                <option value="Sopas" {{ $tipoComida->nombre_categoria == 'Sopas' ? 'selected' : '' }}>Sopas</option>
                ç<option value="Pan" {{ $tipoComida->nombre_categoria == 'Pan' ? 'selected' : '' }}>Pan</option>
            </select>
        </div>

        <div class="form-group">
            <a href="{{ route('tipo_comidas.index') }}" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
        </div>
    </form>
</div>
@endsection
