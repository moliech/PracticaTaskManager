<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_limite',
        'user_id',
        'category_id',
        'estado',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes Locales (Filtros para el Controlador)
    |--------------------------------------------------------------------------
    */

    /**
     * Filtra tareas por título o descripción (Buscador).
     */
    public function scopeBuscar($query, $termino)
    {
        if (trim($termino) !== '') {
            return $query->where(function ($q) use ($termino) {
                $q->where('titulo', 'LIKE', "%{$termino}%")
                  ->orWhere('descripcion', 'LIKE', "%{$termino}%");
            });
        }
    }

    /**
     * Filtra solo las tareas con estado 'completada'.
     */
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    /**
     * Filtra las tareas pendientes o en progreso (No completadas).
     */
    public function scopePendientes($query)
    {
        // Trae tanto las 'pendiente' como las de 'en_progreso' si se filtra por "No completadas"
        return $query->whereIn('estado', ['pendiente', 'en_progreso']);
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        // Especificamos 'user_id' como la llave foránea ya que no sigue el estándar 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        // Especificamos 'category_id' como la llave foránea para coincidir con tu base de datos
        return $this->belongsTo(Category::class, 'category_id');
    }
}