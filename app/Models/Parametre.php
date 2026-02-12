<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    protected $table = 'parametres';

    public $timestamps = false;

    protected $fillable = [
        'cle',
        'valeur',
        'description',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir la valeur d'un paramètre par sa clé
     */
    public static function get($cle, $default = null)
    {
        $parametre = self::where('cle', $cle)->first();
        
        return $parametre ? $parametre->valeur : $default;
    }

    /**
     * Définir ou mettre à jour un paramètre
     */
    public static function set($cle, $valeur, $description = null)
    {
        return self::updateOrCreate(
            ['cle' => $cle],
            [
                'valeur' => $valeur,
                'description' => $description,
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Vérifier si un paramètre existe
     */
    public static function has($cle): bool
    {
        return self::where('cle', $cle)->exists();
    }

    /**
     * Supprimer un paramètre
     */
    public static function remove($cle)
    {
        return self::where('cle', $cle)->delete();
    }

    /**
     * Obtenir tous les paramètres sous forme de tableau clé => valeur
     */
    public static function getAllAsArray(): array
    {
        return self::pluck('valeur', 'cle')->toArray();
    }
}
