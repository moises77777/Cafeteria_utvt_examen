{{--
================================================================================
VISTA: INDEX DE TIPOS DE COMIDA (tipo_comidas/index.blade.php)
================================================================================

¿Qué es Blade?
Blade es el motor de plantillas de Laravel. Es como "HTML con superpoderes"
que te permite escribir PHP de forma más limpia y elegante.

EXTENSIÓN: .blade.php (no solo .php)

VENTAJAS DE BLADE:
1. Sintaxis limpia: {{ $variable }} en lugar de <?php echo $variable; ?>
2. Herencia de plantillas: @extends, @section, @yield
3. Directivas: @if, @foreach, @csrf (más fácil que escribir HTML/PHP mezclado)
4. No hay penalización de rendimiento (se compila a PHP plano)

================================================================================
HERENCIA DE PLANTILLAS (@extends)
================================================================================

Esta vista "hereda" de layout.blade.php (la plantilla base).
Es como decir: "Usa el diseño de layout.blade.php pero reemplaza ciertas partes"

En layout.blade.php hay secciones definidas con @yield('nombre'):
- @yield('title') → Nosotros la llenamos con @section('title')
- @yield('content') → Nosotros la llenamos con @section('content')

================================================================================
DATOS RECIBIDOS DEL CONTROLADOR
================================================================================

El controlador TipoComidaController@index nos pasa:
- $tiposComida: Colección de objetos TipoComida

Ejemplo de estructura de cada $tipo:
$tipo->id_tipo_comida = 1
$tipo->nombre_categoria = "Bebidas"
$tipo->created_at = 2026-02-27 15:30:00
$tipo->updated_at = 2026-02-27 15:30:00
--}}

{{-- Heredamos del layout principal --}}
@extends('layout')

{{-- Definimos el título de la página (se inyecta en @yield('title') del layout) --}}
@section('title', 'Tipos de Comida - Cafetería UTV')

{{-- Definimos el contenido principal (se inyecta en @yield('content') del layout) --}}
@section('content')
<div class="card">
    {{-- Encabezado con título y botón de acción --}}
    <div class="header-actions">
        <h1>Tipos de Comida</h1>
        {{--
        route('tipo_comidas.create') genera la URL completa:
        http://127.0.0.1:8000/tipo_comidas/create
        
        Es mejor usar route() que escribir URLs hardcodeadas porque:
        1. Si cambia la URL, los enlaces siguen funcionando
        2. Es más legible y mantenible
        --}}
        <a href="{{ route('tipo_comidas.create') }}" class="btn btn-success">+ Nuevo Tipo</a>
    </div>

    {{-- Tabla de datos --}}
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
            {{--
            @forelse es una directiva especial de Blade:
            - Funciona como foreach, pero tiene un bloque @empty
            - Si la colección está vacía, muestra el contenido de @empty
            - Evita tener que escribir @if(count($tiposComida) > 0)
            
            Equivalente en PHP:
            foreach ($tiposComida as $tipo) { ... }
            --}}
            @forelse($tiposComida as $tipo)
            <tr>
                {{-- {{ }} escapa HTML (seguro contra XSS) --}}
                <td>{{ $tipo->id_tipo_comida }}</td>
                <td>{{ $tipo->nombre_categoria }}</td>
                
                {{--
                Método format() de Carbon (Laravel maneja fechas con Carbon):
                'd/m/Y H:i' = día/mes/año hora:minuto
                Ejemplo: 27/02/2026 15:30
                --}}
                <td>{{ $tipo->created_at->format('d/m/Y H:i') }}</td>
                
                <td class="actions">
                    {{-- Botón Ver (detalles) --}}
                    <a href="{{ route('tipo_comidas.show', $tipo->id_tipo_comida) }}" class="btn btn-primary">Ver</a>
                    
                    {{-- Botón Editar --}}
                    <a href="{{ route('tipo_comidas.edit', $tipo->id_tipo_comida) }}" class="btn btn-warning">Editar</a>
                    
                    {{--
                    Formulario para Eliminar (método DELETE)
                    
                    ¿Por qué usamos un formulario y no solo un enlace?
                    Porque eliminar debe ser DELETE, no GET. Los enlaces (<a>) solo hacen GET.
                    
                    @csrf:
                    Token de seguridad obligatorio en formularios POST/PUT/DELETE
                    Protege contra ataques CSRF (Cross-Site Request Forgery)
                    
                    @method('DELETE'):
                    HTML solo soporta GET y POST. Laravel usa este truco:
                    - El formulario se envía como POST
                    - Pero incluye un campo oculto indicando que es DELETE
                    - Laravel lo interpreta como DELETE request
                    
                    onclick="return confirm(...)
                    Muestra un cuadro de diálogo de confirmación antes de eliminar
                    Evita eliminaciones accidentales
                    --}}
                    <form action="{{ route('tipo_comidas.destroy', $tipo->id_tipo_comida) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de comida?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            {{-- Este bloque se muestra si $tiposComida está vacío --}}
            <tr>
                <td colspan="4" style="text-align:center;">No hay tipos de comida registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
