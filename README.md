# 🍽️ Cafetería UTV - Sistema de Gestión

Sistema CRUD desarrollado en **Laravel 11** para la gestión de tipos de comida y comidas de la **Universidad Tecnológica del Valle de Toluca**.

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **XAMPP** (Apache + MySQL + PHP 8.2+)
- **Composer** (gestor de dependencias PHP)
- **Git** (para clonar el repositorio)

## 🚀 Instalación y Configuración

Sigue estos pasos en orden:

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tuusuario/cafateria_utvt.git
cd cafateria_utvt
```

### 2. Instalar Dependencias

```bash
composer install
```

### 3. Configurar Archivo de Entorno

Copia el archivo de ejemplo y edítalo:

```bash
copy .env.example .env
```

Edita el archivo `.env` y configura tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafeteria_utvt    # Crea esta BD en phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=                    # Deja vacío si no tienes contraseña
```

### 4. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 5. Crear Base de Datos

1. Abre **phpMyAdmin** (http://localhost/phpmyadmin)
2. Crea una base de datos llamada: `cafeteria_utvt`
3. Selecciona **utf8mb4_unicode_ci** como collation

### 6. Ejecutar Migraciones

```bash
php artisan migrate
```

Esto creará las tablas:
- `tb_tipo_comidas` - Tipos de comida (Bebidas, Postres, etc.)
- `tb_comidas` - Comidas con relación a tipos

### 7. Iniciar el Servidor

```bash
php artisan serve
```

El sistema estará disponible en: **http://127.0.0.1:8000**

## 📁 Estructura del Proyecto

```
cafateria_utvt/
├── app/
│   ├── Http/Controllers/     # Controladores (lógica)
│   │   ├── TipoComidaController.php
│   │   └── ComidaController.php
│   └── Models/               # Modelos (Eloquent ORM)
│       ├── TipoComida.php
│       └── Comida.php
├── database/migrations/      # Estructura de tablas
├── resources/views/          # Vistas Blade
│   ├── layout.blade.php      # Plantilla base
│   ├── tipo_comidas/         # CRUD tipos de comida
│   └── comidas/              # CRUD comidas
├── routes/
│   └── web.php               # Definición de rutas
└── .env                      # Configuración local
```

## 🎯 Funcionalidades

- ✅ **Crear** tipos de comida y comidas
- ✅ **Leer** listados con relaciones
- ✅ **Actualizar** registros existentes
- ✅ **Eliminar** con validación de integridad
- ✅ **Validaciones** en formularios
- ✅ **Mensajes** de éxito/error
- ✅ **Relaciones** de llave foránea

## 🔗 Rutas Disponibles

| URL | Función |
|-----|---------|
| `/tipo_comidas` | Listar tipos de comida |
| `/tipo_comidas/create` | Crear nuevo tipo |
| `/comidas` | Listar comidas |
| `/comidas/create` | Crear nueva comida |

## 📚 Documentación del Código

El código está completamente documentado con comentarios explicativos en español:

- **Modelos**: Explicación de Eloquent, relaciones, fillable
- **Controladores**: Patrón MVC, método CRUD, validaciones
- **Migraciones**: Tipos de datos, llaves foráneas, comandos
- **Rutas**: Route::resource, parámetros, redirecciones
- **Vistas**: Blade, herencia, directivas, seguridad

## 👥 Equipo de Desarrollo

Proyecto desarrollado para la materia de **Programación Web** - UTV.

## 📄 Licencia

Este proyecto es para fines educativos.
