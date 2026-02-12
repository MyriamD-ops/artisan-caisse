<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSynchronisation extends Model
{
    use HasFactory;

    protected $table = 'logs_synchronisation';

    public $timestamps = false;

    protected $fillable = [
        'type_sync',
        'statut',
        'nombre_enregistrements',
        'message_erreur',
        'date_sync',
    ];

    protected $casts = [
        'nombre_enregistrements' => 'integer',
        'date_sync' => 'datetime',
    ];

    // ===== MÉTHODES UTILES =====

    /**
     * Créer un log de synchronisation réussie
     */
    public static function logSucces($type, $nombre = 0)
    {
        return self::create([
            'type_sync' => $type,
            'statut' => 'succes',
            'nombre_enregistrements' => $nombre,
            'date_sync' => now(),
        ]);
    }

    /**
     * Créer un log de synchronisation échouée
     */
    public static function logEchec($type, $message_erreur, $nombre = 0)
    {
        return self::create([
            'type_sync' => $type,
            'statut' => 'echec',
            'nombre_enregistrements' => $nombre,
            'message_erreur' => $message_erreur,
            'date_sync' => now(),
        ]);
    }

    /**
     * Créer un log de synchronisation partielle
     */
    public static function logPartiel($type, $nombre, $message = null)
    {
        return self::create([
            'type_sync' => $type,
            'statut' => 'partiel',
            'nombre_enregistrements' => $nombre,
            'message_erreur' => $message,
            'date_sync' => now(),
        ]);
    }

    /**
     * Scope par type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type_sync', $type);
    }

    /**
     * Scope par statut
     */
    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    /**
     * Scope pour les succès
     */
    public function scopeSucces($query)
    {
        return $query->where('statut', 'succes');
    }

    /**
     * Scope pour les échecs
     */
    public function scopeEchec($query)
    {
        return $query->where('statut', 'echec');
    }

    /**
     * Obtenir la dernière synchronisation d'un type donné
     */
    public static function derniere($type = null)
    {
        $query = self::latest('date_sync');
        
        if ($type) {
            $query->where('type_sync', $type);
        }
        
        return $query->first();
    }

    /**
     * Obtenir le taux de succès pour un type donné
     */
    public static function tauxSucces($type = null)
    {
        $query = self::query();
        
        if ($type) {
            $query->where('type_sync', $type);
        }
        
        $total = $query->count();
        
        if ($total === 0) {
            return 0;
        }
        
        $succes = (clone $query)->where('statut', 'succes')->count();
        
        return round(($succes / $total) * 100, 2);
    }
}
