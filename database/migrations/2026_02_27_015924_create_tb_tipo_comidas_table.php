<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * MIGRACIÓN: CREAR TABLA TB_TIPO_COMIDAS
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * ¿Qué es una Migración?
 * Es como un "control de versiones" para tu base de datos.
 * Te permite crear, modificar y eliminar tablas de forma programática.
 * 
 * BENEFICIOS:
 * 1. Todos en el equipo tienen la misma estructura de BD
 * 2. Puedes "deshacer" cambios si algo sale mal
 * 3. No necesitas escribir SQL manualmente
 * 
 * COMANDOS IMPORTANTES:
 * - php artisan migrate        → Ejecuta todas las migraciones pendientes
 * - php artisan migrate:rollback → Deshace la última migración
 * - php artisan migrate:fresh  → Borra todo y recrea desde cero
 * 
 * ESTRUCTURA DE ESTA MIGRACIÓN:
 * Tabla: tb_tipo_comidas (Tipos de comida: Bebidas, Postres, etc.)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO UP - Crear la tabla
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Este método se ejecuta cuando corres: php artisan migrate
     * Aquí defines la estructura de la tabla (columnas, tipos, llaves, etc.)
     */
    public function up(): void
    {
        Schema::create('tb_tipo_comidas', function (Blueprint $table) {
            
            /**
             * LLAVE PRIMARIA
             * $table->id() crea un campo 'id' auto-incremental
             * Al pasar 'id_tipo_comida', personalizamos el nombre del campo
             * Es equivalente a: INT AUTO_INCREMENT PRIMARY KEY
             */
            $table->id('id_tipo_comida');
            
            /**
             * CAMPO ENUM (Enumeración)
             * Solo permite valores específicos de una lista
             * 
             * Ventajas:
             * - Asegura que solo entren valores válidos
             * - Ahorra espacio (internamente guarda números, no texto)
             * 
             * Desventajas:
             * - Para agregar nuevos valores, necesitas modificar la migración
             */
            $table->enum('nombre_categoria', [
                'Bebidas', 
                'Postres', 
                'Platillos Fuertes', 
                'Entradas', 
                'Sopas'
            ]);
            
            /**
             * TIMESTAMPS (Fechas automáticas)
             * Crea dos campos:
             * - created_at: Fecha/hora cuando se creó el registro
             * - updated_at: Fecha/hora de la última modificación
             * 
             * Laravel los llena automáticamente, tú no tienes que hacer nada
             */
            $table->timestamps();
        });
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * MÉTODO DOWN - Eliminar la tabla
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Este método se ejecuta cuando corres: php artisan migrate:rollback
     * Es el "deshacer" de la migración - elimina lo que creó up()
     * 
     * IMPORTANTE: dropIfExists verifica si existe antes de eliminar
     * para evitar errores si la tabla no existe
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tipo_comidas');
    }
};
