<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * MODELO: COMIDA
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Este modelo representa la tabla 'tb_comidas' en la base de datos.
 * 
 * RELACIÓN CON TIPO_COMIDA:
 * - Cada Comida pertenece a UN Tipo de Comida (belongsTo)
 * - El campo id_tipo_comida es la llave foránea que conecta ambas tablas
 * 
 * Ejemplo de uso:
 * $comida = Comida::find(1);
 * echo $comida->nombre_comida; // Muestra el nombre
 * echo $comida->tipoComida->nombre_categoria; // Muestra la categoría relacionada
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * CONFIGURACIÓN DE LA TABLA
     * ═══════════════════════════════════════════════════════════════════════════
     */
    
    /** Nombre de la tabla en la base de datos */
    protected $table = 'tb_comidas';
    
    /** Llave primaria de la tabla */
    protected $primaryKey = 'id_comida';
    
    /** Habilitar timestamps automáticos (created_at, updated_at) */
    public $timestamps = true;

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * CAMPOS PERMITIDOS (FILLABLE)
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Estos campos pueden ser llenados masivamente mediante:
     * Comida::create($request->all()) o $comida->update($request->all())
     * 
     * NOTA DE SEGURIDAD:
     * Siempre usa $fillable o $guarded para prevenir asignación masiva no deseada.
     * Nunca incluyas campos sensibles como IDs o estados de administrador aquí.
     */
    protected $fillable = [
        'nombre_comida',    // Nombre de la comida (varchar 100)
        'costo',            // Precio en decimal (8,2)
        'detalle_comida',   // Descripción detallada (text)
        'id_tipo_comida'    // Llave foránea que relaciona con tb_tipo_comidas
    ];

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * RELACIÓN: MUCHAS COMIDAS PERTENECEN A UN TIPO DE COMIDA
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Relación: Many-to-One (Muchos a Uno) o belongsTo
     * - MUCHAS Comidas pertenecen a UN Tipo de Comida
     * 
     * Ejemplo de uso:
     * $comida = Comida::find(1);
     * $tipo = $comida->tipoComida; // Obtiene el tipo de comida relacionado
     * echo $tipo->nombre_categoria; // Muestra: "Bebidas", "Postres", etc.
     */
    public function tipoComida()
    {
        /**
         * belongsTo() indica que este modelo (Comida) pertenece a un solo
         * registro del modelo relacionado (TipoComida).
         * 
         * Parámetros:
         * 1. TipoComida::class = El modelo padre
         * 2. 'id_tipo_comida' = Llave foránea en ESTA tabla (tb_comidas)
         * 3. 'id_tipo_comida' = Llave primaria en la tabla padre (tb_tipo_comidas)
         */
        return $this->belongsTo(TipoComida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
