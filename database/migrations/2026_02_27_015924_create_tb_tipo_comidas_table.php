<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración para crear tabla tb_tipo_comidas - Almacena categorías del menú
// Define estructura con ID autoincremental y campo enum con valores predefinidos
return new class extends Migration
{
    // Ejecuta la creación de la tabla cuando se corre php artisan migrate
    // Crea estructura completa con tipos de datos y restricciones necesarias
    public function up(): void
    {
        Schema::create('tb_tipo_comidas', function (Blueprint $table) {
            // ID primario autoincremental de tipo BIGINT UNSIGNED
            $table->id('id_tipo_comida');
            
            // Campo ENUM con valores predefinidos para categorías estándar
            // Restringe los valores a las opciones válidas del sistema
            $table->enum('nombre_categoria', ['Bebidas', 'Postres', 'Platillos Fuertes', 'Entradas', 'Sopas', 'Pan']);
            
            // Timestamps automáticos para registro de creación y actualización
            $table->timestamps();
        });
    }

    // Elimina la tabla si existe cuando se corre php artisan migrate:rollback
    // Permite revertir cambios y mantener limpio el esquema de base de datos
    public function down(): void
    {
        Schema::dropIfExists('tb_tipo_comidas');
    }
};
