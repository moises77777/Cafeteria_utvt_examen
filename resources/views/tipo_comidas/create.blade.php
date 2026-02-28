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
            <input type="text" name="nombre_categoria" id="nombre_categoria" placeholder="Ej: Bebidas, Postres, Platillos Fuertes..." required>
        </div>

        <div class="form-group">
            <a href="{{ route('tipo_comidas.index') }}" class="btn btn-primary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection
