@extends('layout')

@section('title', 'Nuevo Tipo de Comida - Cafetería UTV')

@section('content')
<div class="card">
    <h1>Crear Nuevo Tipo de Comida</h1>

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tipo_comidas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre_categoria">Categoría:</label>
            <select name="nombre_categoria" id="nombre_categoria" required>
                <option value="">Seleccione una categoría</option>
                <option value="Bebidas">Bebidas</option>
                <option value="Postres">Postres</option>
                <option value="Platillos Fuertes">Platillos Fuertes</option>
                <option value="Entradas">Entradas</option>
                <option value="Sopas">Sopas</option>
            </select>
        </div>

        <div class="form-group">
            <a href="{{ route('tipo_comidas.index') }}" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection
