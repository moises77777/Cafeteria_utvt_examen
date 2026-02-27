<?php

/**
 * ═══════════════════════════════════════════════════════════════════════════════
 * MODELO: TIPO COMIDA
 * ═══════════════════════════════════════════════════════════════════════════════
 * 
 * Este modelo representa la tabla 'tb_tipo_comidas' en la base de datos.
 * Es como una "plantilla" que nos permite interactuar con los datos de la BD.
 * 
 * ¿Qué es un Modelo en Laravel?
 * Un modelo es una clase PHP que nos permite:
 * 1. Consultar datos de la base de datos
 * 2. Insertar nuevos registros
 * 3. Actualizar registros existentes
 * 4. Eliminar registros
 * 5. Definir relaciones entre tablas
 * 
 * Eloquent ORM:
 * Laravel usa Eloquent, que convierte las tablas de la BD en objetos PHP.
 * Esto nos permite trabajar con la BD usando código PHP en lugar de SQL.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComida extends Model
{
    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * CONFIGURACIÓN DE LA TABLA
     * ═══════════════════════════════════════════════════════════════════════════
     */
    
    /**
     * Nombre de la tabla en la base de datos.
     * Por defecto Laravel busca el plural del modelo (tipo_comidas),
     * pero como usamos 'tb_' como prefijo, debemos especificarlo.
     */
    protected $table = 'tb_tipo_comidas';
    
    /**
     * Nombre de la llave primaria.
     * Por defecto Laravel usa 'id', pero nuestra tabla usa 'id_tipo_comida'.
     */
    protected $primaryKey = 'id_tipo_comida';
    
    /**
     * Indica si Laravel debe manejar automáticamente los timestamps.
     * Si es true, Laravel llenará 'created_at' y 'updated_at' automáticamente.
     */
    public $timestamps = true;

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * CAMPOS PERMITIDOS PARA ASIGNACIÓN MASIVA
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * $fillable define qué campos pueden ser llenados cuando usamos:
     * TipoComida::create($request->all()) o $tipoComida->update($request->all())
     * 
     * Esto es una medida de seguridad para evitar que usuarios maliciosos
     * modifiquen campos que no deberían (como el ID o timestamps).
     */
    protected $fillable = [
        'nombre_categoria'  // Solo este campo puede ser asignado masivamente
    ];

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * RELACIÓN: UN TIPO DE COMIDA TIENE MUCHAS COMIDAS
     * ═══════════════════════════════════════════════════════════════════════════
     * 
     * Esta función define la relación entre tablas.
     * 
     * Relación: One-to-Many (Uno a Muchos)
     * - Un Tipo de Comida puede tener MUCHAS Comidas
     * - Cada Comida pertenece a UN solo Tipo de Comida
     * 
     * Ejemplo de uso:
     * $tipo = TipoComida::find(1);
     * $comidas = $tipo->comidas; // Obtiene todas las comidas de ese tipo
     */
    public function comidas()
    {
        /**
         * hasMany() indica que este modelo (TipoComida) tiene muchos registros
         * en el modelo relacionado (Comida).
         * 
         * Parámetros:
         * 1. Comida::class = El modelo relacionado
         * 2. 'id_tipo_comida' = Llave foránea en la tabla tb_comidas
         * 3. 'id_tipo_comida' = Llave primaria en esta tabla (tb_tipo_comidas)
         */
        return $this->hasMany(Comida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
