# DOCUMENTACIÓN DEL PROYECTO CAFETERÍA UTV
## Sistema de Gestión CRUD en Laravel 11

---

# PORTADA

**UNIVERSIDAD TECNOLÓGICA DEL VALLE DE TOLUCA**

![Logo UTV]

---

**MATERIA:** Programación Web

**PROYECTO:** Sistema de Gestión de Cafetería UTV

**INTEGRANTES:**
- [Nombre del integrante 1]
- [Nombre del integrante 2]
- [Nombre del integrante 3]

**FECHA:** 26 de febrero de 2026

**SEMESTRE:** [Tu semestre]

**CARRERA:** [Tu carrera]

---

**ÍNDICE**

1. Introducción
2. Objetivos
3. Diagrama de Base de Datos
4. Desarrollo del Sistema
   - 4.1 Migraciones
   - 4.2 Modelos
   - 4.3 Controladores
   - 4.4 Rutas
   - 4.5 Vistas
5. Funcionalidades del Sistema
6. Conclusiones
7. Referencias

---

# 1. INTRODUCCIÓN

## 1.1 Descripción del Proyecto

El presente proyecto consiste en el desarrollo de un sistema web de gestión para la cafetería de la Universidad Tecnológica del Valle de Toluca (UTVT). Este sistema permite administrar dos entidades principales: los tipos de comida (categorías) y las comidas ofrecidas.

El sistema fue desarrollado utilizando el framework **Laravel 11**, que implementa el patrón de arquitectura **MVC (Model-View-Controller)**. Este patrón separa la lógica de negocio, la interfaz de usuario y el control de la aplicación, facilitando el mantenimiento y escalabilidad del código.

## 1.2 Justificación

La cafetería de la UTV requiere un sistema digital para gestionar su menú de forma eficiente. Anteriormente, esta información se manejaba de forma manual o dispersa. Con este sistema se logra:

- Centralizar la información del menú
- Facilitar la actualización de precios y descripciones
- Categorizar los alimentos para mejor organización
- Mantener un registro histórico de cambios mediante timestamps

## 1.3 Tecnologías Utilizadas

- **Framework:** Laravel 11 (PHP 8.2+)
- **Base de Datos:** MySQL (mediante XAMPP)
- **Servidor Web:** Apache
- **Frontend:** HTML5, CSS3, Blade (motor de plantillas)
- **Control de Versiones:** Git y GitHub
- **Herramientas:** Composer, phpMyAdmin

---

# 2. OBJETIVOS

## 2.1 Objetivo General

Desarrollar un sistema web CRUD (Create, Read, Update, Delete) completo para la gestión de tipos de comida y comidas de la cafetería UTVT, implementando relaciones de base de datos y validaciones de formularios.

## 2.2 Objetivos Específicos

1. Diseñar e implementar una base de datos relacional con llaves foráneas
2. Crear las migraciones necesarias para la estructura de la BD
3. Desarrollar modelos Eloquent con relaciones entre tablas
4. Implementar controladores con operaciones CRUD completas
5. Diseñar vistas responsivas utilizando Blade
6. Configurar rutas RESTful para todas las operaciones
7. Implementar validaciones de formularios
8. Agregar mensajes de confirmación de éxito y error

---

# 3. DIAGRAMA DE BASE DE DATOS

## 3.1 Estructura de Tablas

El sistema consta de dos tablas principales con una relación de uno a muchos (One-to-Many):

### Tabla: tb_tipo_comidas (Tabla Padre)
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_tipo_comida | INT (PK, Auto) | Identificador único |
| nombre_categoria | ENUM | Valores: Bebidas, Postres, Platillos Fuertes, Entradas, Sopas |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de última modificación |

### Tabla: tb_comidas (Tabla Hija)
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_comida | INT (PK, Auto) | Identificador único |
| nombre_comida | VARCHAR(100) | Nombre del platillo |
| costo | DECIMAL(8,2) | Precio del platillo |
| detalle_comida | TEXT | Descripción completa |
| id_tipo_comida | INT (FK) | Relación con tb_tipo_comidas |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de última modificación |

## 3.2 Diagrama Entidad-Relación

```
┌─────────────────────────────────┐
│      tb_tipo_comidas            │
├─────────────────────────────────┤
│ PK  id_tipo_comida: INT         │
│     nombre_categoria: ENUM      │
│     created_at: TIMESTAMP       │
│     updated_at: TIMESTAMP       │
└───────────────┬─────────────────┘
                │
                │ 1
                │
                │ N
┌───────────────▼─────────────────┐
│         tb_comidas              │
├─────────────────────────────────┤
│ PK  id_comida: INT              │
│     nombre_comida: VARCHAR(100) │
│     costo: DECIMAL(8,2)         │
│     detalle_comida: TEXT        │
│ FK  id_tipo_comida: INT         │
│     created_at: TIMESTAMP       │
│     updated_at: TIMESTAMP       │
└─────────────────────────────────┘
```

**Tipo de Relación:** One-to-Many (Uno a Muchos)
- Un Tipo de Comida puede tener **muchas** Comidas
- Una Comida pertenece a **un solo** Tipo de Comida

---

# 4. DESARROLLO DEL SISTEMA

## 4.1 MIGRACIONES

Las migraciones en Laravel son como un "control de versiones" para la base de datos. Permiten versionar los cambios en la estructura de la BD de forma programática.

### Migración: tb_tipo_comidas

```php
Schema::create('tb_tipo_comidas', function (Blueprint $table) {
    $table->id('id_tipo_comida');
    $table->enum('nombre_categoria', [
        'Bebidas', 
        'Postres', 
        'Platillos Fuertes', 
        'Entradas', 
        'Sopas'
    ]);
    $table->timestamps();
});
```

**Características:**
- Llave primaria auto-incremental personalizada
- Campo ENUM para restringir valores permitidos
- Timestamps automáticos (created_at, updated_at)

### Migración: tb_comidas

```php
Schema::create('tb_comidas', function (Blueprint $table) {
    $table->id('id_comida');
    $table->string('nombre_comida', 100);
    $table->decimal('costo', 8, 2);
    $table->text('detalle_comida');
    $table->unsignedBigInteger('id_tipo_comida');
    $table->foreign('id_tipo_comida')
          ->references('id_tipo_comida')
          ->on('tb_tipo_comidas');
    $table->timestamps();
});
```

**Características:**
- Campos de diferentes tipos (string, decimal, text)
- Llave foránea que referencia a tb_tipo_comidas
- Integridad referencial: no permite crear comidas con tipos inexistentes

## 4.2 MODELOS (Eloquent ORM)

Eloquent es el ORM (Object-Relational Mapping) de Laravel que permite trabajar con la base de datos usando objetos PHP en lugar de SQL.

### Modelo: TipoComida

```php
class TipoComida extends Model
{
    protected $table = 'tb_tipo_comidas';
    protected $primaryKey = 'id_tipo_comida';
    public $timestamps = true;

    protected $fillable = ['nombre_categoria'];

    // Relación: Un tipo tiene muchas comidas
    public function comidas()
    {
        return $this->hasMany(Comida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
```

### Modelo: Comida

```php
class Comida extends Model
{
    protected $table = 'tb_comidas';
    protected $primaryKey = 'id_comida';
    public $timestamps = true;

    protected $fillable = [
        'nombre_comida',
        'costo',
        'detalle_comida',
        'id_tipo_comida'
    ];

    // Relación: Una comida pertenece a un tipo
    public function tipoComida()
    {
        return $this->belongsTo(TipoComida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
```

**Conceptos Clave:**
- **$fillable:** Campos que pueden ser asignados masivamente (seguridad)
- **Relaciones:** hasMany() para uno-a-muchos, belongsTo() para muchos-a-uno
- **Timestamps:** Laravel gestiona automáticamente las fechas

## 4.3 CONTROLADORES

Los controladores actúan como intermediarios entre el usuario y la base de datos, implementando el patrón MVC.

### TipoComidaController - Métodos CRUD

| Método | URL | Función |
|--------|-----|---------|
| index() | GET /tipo_comidas | Listar todos los tipos |
| create() | GET /tipo_comidas/create | Mostrar formulario de creación |
| store() | POST /tipo_comidas | Guardar nuevo tipo |
| show() | GET /tipo_comidas/{id} | Ver detalles de un tipo |
| edit() | GET /tipo_comidas/{id}/edit | Mostrar formulario de edición |
| update() | PUT /tipo_comidas/{id} | Actualizar tipo existente |
| destroy() | DELETE /tipo_comidas/{id} | Eliminar tipo |

### Validaciones Implementadas

```php
$request->validate([
    'nombre_categoria' => 'required|in:Bebidas,Postres,Platillos Fuertes,Entradas,Sopas'
]);
```

**Validaciones en ComidaController:**
- `required` - Campo obligatorio
- `string|max:100` - Texto máximo 100 caracteres
- `numeric|min:0` - Número positivo
- `exists:tb_tipo_comidas,id_tipo_comida` - Verifica que el tipo exista

### Eager Loading (Optimización de Consultas)

```php
// Sin eager loading (N+1 queries)
$comidas = Comida::all();
foreach ($comidas as $comida) {
    echo $comida->tipoComida->nombre_categoria; // Query adicional
}

// Con eager loading (solo 2 queries)
$comidas = Comida::with('tipoComida')->get();
```

## 4.4 RUTAS

Laravel utiliza el archivo `routes/web.php` para definir todas las URL disponibles.

### Route::resource()

En lugar de definir 7 rutas manualmente, usamos:

```php
Route::resource('tipo_comidas', TipoComidaController::class);
Route::resource('comidas', ComidaController::class);
```

Esto genera automáticamente todas las rutas CRUD con sus nombres:

| Método HTTP | URL | Nombre de Ruta | Acción |
|-------------|-----|----------------|--------|
| GET | /tipo_comidas | tipo_comidas.index | Listar |
| GET | /tipo_comidas/create | tipo_comidas.create | Formulario crear |
| POST | /tipo_comidas | tipo_comidas.store | Guardar |
| GET | /tipo_comidas/{id} | tipo_comidas.show | Mostrar |
| GET | /tipo_comidas/{id}/edit | tipo_comidas.edit | Formulario editar |
| PUT | /tipo_comidas/{id} | tipo_comidas.update | Actualizar |
| DELETE | /tipo_comidas/{id} | tipo_comidas.destroy | Eliminar |

**Uso en Vistas:**
```php
<a href="{{ route('tipo_comidas.create') }}">Nuevo</a>
<form action="{{ route('tipo_comidas.destroy', $id) }}" method="POST">
```

## 4.5 VISTAS (Blade)

Blade es el motor de plantillas de Laravel que permite escribir PHP de forma limpia.

### Herencia de Plantillas

**layout.blade.php** (Plantilla base):
```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    <nav>...</nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

**Vista hija** (index.blade.php):
```blade
@extends('layout')

@section('title', 'Tipos de Comida')

@section('content')
    <h1>Listado</h1>
    <!-- Contenido específico -->
@endsection
```

### Directivas Blade Utilizadas

| Directiva | Función |
|-----------|---------|
| `@extends()` | Hereda de plantilla base |
| `@section()` | Define sección de contenido |
| `@yield()` | Muestra contenido de sección |
| `@forelse()` | Bucle con manejo de colección vacía |
| `@empty()` | Bloque cuando no hay registros |
| `@csrf` | Token de seguridad anti-CSRF |
| `@method()` | Simula métodos HTTP (PUT, DELETE) |

### Seguridad en Formularios

```blade
<form method="POST">
    @csrf           {{-- Protección CSRF --}}
    @method('DELETE') {{-- Simula DELETE --}}
    <button onclick="return confirm('¿Eliminar?')">Eliminar</button>
</form>
```

---

# 5. FUNCIONALIDADES DEL SISTEMA

## 5.1 Gestión de Tipos de Comida

✅ **Crear:** Formulario con dropdown de categorías (ENUM)
✅ **Listar:** Tabla con todos los tipos y fechas
✅ **Ver:** Página de detalles del tipo
✅ **Editar:** Formulario precargado con datos actuales
✅ **Eliminar:** Con validación de integridad (no permite si tiene comidas relacionadas)

## 5.2 Gestión de Comidas

✅ **Crear:** Formulario con campos de nombre, costo, descripción y selector de tipo
✅ **Listar:** Tabla con relación a tipo de comida (usando eager loading)
✅ **Ver:** Detalles completos incluyendo la categoría
✅ **Editar:** Formulario con todos los datos precargados
✅ **Eliminar:** Eliminación directa (no requiere validación de relaciones)

## 5.3 Características Adicionales

✅ **Validaciones:** Todos los formularios validan datos antes de procesar
✅ **Mensajes:** Flash messages de éxito y error
✅ **Integridad:** Verificación de llaves foráneas
✅ **Responsive:** Diseño adaptable a dispositivos móviles
✅ **Logo:** Identidad visual de Cafetería UTV

---

# 6. CONCLUSIONES

## 6.1 Logros del Proyecto

1. **Implementación exitosa del patrón MVC:** El código está organizado siguiendo las mejores prácticas de Laravel, separando claramente Modelos, Vistas y Controladores.

2. **Relaciones de base de datos:** Se implementó correctamente la relación uno-a-muchos con llave foránea, garantizando integridad referencial.

3. **CRUD completo:** Ambas entidades (TipoComida y Comida) cuentan con operaciones Crear, Leer, Actualizar y Eliminar totalmente funcionales.

4. **Seguridad:** Se implementaron medidas como protección CSRF, validación de formularios y escape de HTML (XSS protection).

5. **Documentación:** Todo el código incluye comentarios explicativos detallados para facilitar el aprendizaje.

## 6.2 Dificultades Encontradas

- Configuración inicial de la base de datos en XAMPP
- Comprensión de las relaciones Eloquent (hasMany vs belongsTo)
- Implementación de los métodos HTTP correctos en formularios (DELETE, PUT)

## 6.3 Aprendizajes

- Uso del framework Laravel 11 y su estructura MVC
- Implementación de migraciones para control de versiones de BD
- Creación de relaciones entre tablas usando Eloquent ORM
- Desarrollo de interfaces con Blade y herencia de plantillas
- Manejo de rutas RESTful con Route::resource()

---

# 7. REFERENCIAS

1. **Laravel Documentation.** (2024). *Laravel 11 - The PHP Framework for Web Artisans.* Recuperado de: https://laravel.com/docs/11.x

2. **Laracasts.** (2024). *Laravel Tutorial for Beginners.* Recuperado de: https://laracasts.com

3. **Taylor Otwell.** (2024). *Laravel: Up & Running.* O'Reilly Media.

4. **W3Schools.** (2024). *PHP Tutorial.* Recuperado de: https://www.w3schools.com/php/

5. **MySQL Documentation.** (2024). *MySQL Reference Manual.* Recuperado de: https://dev.mysql.com/doc/

---

# ANEXOS

## A. Comandos Git Utilizados

```bash
# Inicializar repositorio
git init

# Agregar archivos
git add .

# Realizar commit
git commit -m "Sistema CRUD Cafetería UTV"

# Conectar con GitHub
git remote add origin https://github.com/moises77777/cafeteria.git

# Subir código
git push -u origin main
```

## B. Comandos Artisan Utilizados

```bash
# Crear migraciones
php artisan make:migration create_tb_tipo_comidas_table
php artisan make:migration create_tb_comidas_table

# Ejecutar migraciones
php artisan migrate

# Crear modelos
php artisan make:model TipoComida
php artisan make:model Comida

# Crear controladores
php artisan make:controller TipoComidaController --resource
php artisan make:controller ComidaController --resource

# Iniciar servidor
php artisan serve
```

## C. URL del Repositorio

**GitHub:** https://github.com/moises77777/cafeteria

---

**FIN DEL DOCUMENTO**
