<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración para crear tabla tb_comidas - Tabla principal del sistema de cafetería
// Almacena productos del menú con precios, descripciones y relación a categorías
return new class extends Migration
{
    // Ejecuta la creación de la tabla con estructura completa y relaciones
    // Define todos los campos necesarios para el sistema de gestión de comidas
    public function up(): void
    {
        Schema::create('tb_comidas', function (Blueprint $table) {
            // ID primario autoincremental para identificación única de cada comida
            $table->id('id_comida');
            
            // Nombre del producto con límite de 100 caracteres para consistencia
            $table->string('nombre_comida', 100);
            
            // Precio en formato decimal con 8 dígitos totales y 2 decimales
            // Permite valores hasta 999999.99 para cubrir todos los rangos de precios
            $table->decimal('costo', 8, 2);
            
            // Descripción opcional del producto, puede ser NULL si no se requiere
            // Usa tipo TEXT para permitir descripciones largas y detalladas
            $table->text('detalle_comida')->nullable();
            
            // Llave foránea que relaciona con tb_tipo_comidas
            // Define la categoría a la que pertenece cada comida
            $table->unsignedBigInteger('id_tipo_comida');
            
            // Restricción de integridad referencial para mantener datos consistentes
            // Asegura que todo id_tipo_comida exista en la tabla tb_tipo_comidas
            $table->foreign('id_tipo_comida')->references('id_tipo_comida')->on('tb_tipo_comidas');
            
            // Timestamps automáticos para auditoría y registro de cambios
            $table->timestamps();
        });
    }

    // Elimina la tabla si existe durante rollback de migración
    // Permite revertir completamente los cambios de esta migración
    public function down(): void
    {
        Schema::dropIfExists('tb_comidas');
    }
};
