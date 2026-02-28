<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent para tabla tb_tipo_comidas - Maneja categorías de comida
class TipoComida extends Model
{
    // Configuración personalizada de tabla porque no sigue convención Laravel
    // Laravel esperaría 'tipo_comidas' pero usamos 'tb_tipo_comidas'
    protected $table = 'tb_tipo_comidas';
    
    // Especifica que la llave primaria no es 'id' sino 'id_tipo_comida'
    protected $primaryKey = 'id_tipo_comida';
    
    // Habilita timestamps automáticos para created_at y updated_at
    public $timestamps = true;

    // Define campos que pueden ser asignados masivamente para seguridad
    // Protege contra asignación masiva no autorizada de campos sensibles
    protected $fillable = [
        'nombre_categoria'  // Único campo modificable: nombre de la categoría
    ];

    // Define relación uno a muchos con el modelo Comida usando Eloquent
    // Un tipo de comida puede tener muchas comidas asociadas
    // Parámetros: modelo relacionado, llave foránea, llave primaria local
    public function comidas()
    {
        return $this->hasMany(Comida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
