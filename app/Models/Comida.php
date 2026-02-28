<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent para tabla tb_comidas - Maneja productos del menú de cafetería
class Comida extends Model
{
    // Configuración personalizada porque la tabla no sigue convención Laravel
    // Laravel esperaría 'comidas' pero usamos 'tb_comidas' con prefijo tb_
    protected $table = 'tb_comidas';
    
    // Define llave primaria personalizada 'id_comida' en lugar de 'id' estándar
    protected $primaryKey = 'id_comida';
    
    // Activa timestamps automáticos para registro de creación y actualización
    public $timestamps = true;

    // Lista de campos que pueden ser asignados masivamente por seguridad
    // Evita asignación no autorizada de campos como IDs o timestamps
    protected $fillable = [
        'nombre_comida',        // Nombre del producto (varchar 100)
        'costo',                // Precio en formato decimal (8,2)
        'detalle_comida',       // Descripción opcional del producto (text)
        'id_tipo_comida'        // Llave foránea que relaciona con tb_tipo_comidas
    ];

    // Define relación muchos a uno con el modelo TipoComida usando Eloquent
    // Muchas comidas pueden pertenecer a un solo tipo de comida
    // Parámetros: modelo padre, llave foránea local, llave primaria del padre
    public function tipoComida()
    {
        return $this->belongsTo(TipoComida::class, 'id_tipo_comida', 'id_tipo_comida');
    }
}
