<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * MIGRACIÓN: CREAR TABLA TB_COMIDAS (CON LLAVE FORÁNEA)
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Esta migración es más compleja porque incluye una RELACIÓN entre tablas
 * mediante una LLAVE FORÁNEA (Foreign Key).
 * 
 * ═══════════════════════════════════════════════════════════════════════════════
 * CONCEPTO: LLAVE FORÁNEA (FOREIGN KEY - FK)
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * ¿Qué es?
 * Es un campo que "apunta" a la llave primaria de otra tabla.
 * Establece una relación entre dos tablas.
 * 
 * En este caso:
 * - tb_comidas.id_tipo_comida → apunta a → tb_tipo_comidas.id_tipo_comida
 * 
 * BENEFICIOS DE LAS LLAVES FORÁNEAS:
 * 1. INTEGRIDAD REFERENCIAL: No puedes crear una comida con un tipo inexistente
 * 2. CONSISTENCIA: Evita datos "huérfanos" (comidas sin tipo válido)
 * 3. RELACIONES: Permite hacer JOINs y consultar datos relacionados
 * 
 * TIPOS DE DATOS IMPORTANTES:
 * - unsignedBigInteger: Entero positivo grande (coincide con el tipo de id())
 * - decimal(8,2): Número decimal con 8 dígitos totales, 2 después del punto
 *   Ejemplo: 123456.78 o 9999.99
 * - string(100): VARCHAR(100) - texto con máximo 100 caracteres
 * - text: TEXT - texto largo sin límite específico
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * UP - Crear tabla tb_comidas con llave foránea
     * ═══════════════════════════════════════════════════════════════════════════
     */
    public function up(): void
    {
        Schema::create('tb_comidas', function (Blueprint $table) {
            
            /**
             * LLAVE PRIMARIA
             * id_comida será el identificador único de cada comida
             */
            $table->id('id_comida');
            
            /**
             * STRING - VARCHAR(100)
             * Campo de texto corto para el nombre
             * 100 caracteres es suficiente para nombres de comidas
             */
            $table->string('nombre_comida', 100);
            
            /**
             * DECIMAL(8,2) - Precio/Precisión exacta
             * 8 = total de dígitos (incluyendo decimales)
             * 2 = dígitos después del punto decimal
             * 
             * Rango: 0.00 hasta 999999.99
             * 
             * ¿Por qué decimal y no float?
             * - Decimal almacena valores exactos (importante para dinero)
             * - Float almacena aproximaciones (puede causar errores de centavos)
             */
            $table->decimal('costo', 8, 2);
            
            /**
             * TEXT - Descripción larga
             * Sin límite definido, ideal para descripciones detalladas
             */
            $table->text('detalle_comida');
            
            /**
             * ═══════════════════════════════════════════════════════════════════
             * LLAVE FORÁNEA - RELACIÓN CON TB_TIPO_COMIDAS
             * ═══════════════════════════════════════════════════════════════════
             * 
             * PASO 1: Crear el campo que será llave foránea
             * unsignedBigInteger = mismo tipo que el id() de la tabla padre
             */
            $table->unsignedBigInteger('id_tipo_comida');
            
            /**
             * PASO 2: Definir la restricción de llave foránea
             * 
             * foreign('id_tipo_comida') - El campo en ESTA tabla
             * references('id_tipo_comida') - El campo en la tabla PADRE
             * on('tb_tipo_comidas') - Nombre de la tabla PADRE
             * 
             * COMPORTAMIENTO POR DEFECTO:
             * - ON DELETE RESTRICT: No permite borrar un tipo si tiene comidas
             * - ON UPDATE CASCADE: Si cambia el ID, se actualiza automáticamente
             */
            $table->foreign('id_tipo_comida')
                  ->references('id_tipo_comida')
                  ->on('tb_tipo_comidas');
            
            /**
             * Timestamps automáticos
             */
            $table->timestamps();
        });
    }

    /**
     * DOWN - Eliminar tabla
     * 
     * NOTA: No necesitamos eliminar la llave foránea explícitamente
     * porque dropIfExists elimina toda la tabla incluyendo sus restricciones
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_comidas');
    }
};
