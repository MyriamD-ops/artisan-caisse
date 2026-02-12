<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlerteStock extends Model
{
    use HasFactory;

    protected $table = 'alertes_stock';

    protected $fillable = [
        'produit_id',
        'variante_id',
        'stock_actuel',
        'seuil',
        'statut',
        'resolved_at',
    ];

    protected $casts = [
        'stock_actuel' => 'integer',
        'seuil' => 'integer',
        'resolved_at' => 'datetime',
    ];

    // ===== RELATIONS =====

    /**
     * Le produit concerné
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * La variante concernée (si applicable)
     */
    public function variante()
    {
        return $this->belongsTo(Variante::class, 'variante_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier et créer une alerte si nécessaire
     */
    public static function verifierEtCreer($produit_id, $variante_id, $stock_actuel, $seuil = 5)
    {
        if ($stock_actuel <= $seuil) {
            // Vérifier si une alerte active existe déjà
            $alerteExistante = self::where('produit_id', $produit_id)
                ->where('variante_id', $variante_id)
                ->where('statut', 'active')
                ->first();

            if (!$alerteExistante) {
                return self::create([
                    'produit_id' => $produit_id,
                    'variante_id' => $variante_id,
                    'stock_actuel' => $stock_actuel,
                    'seuil' => $seuil,
                    'statut' => 'active',
                ]);
            }
        }

        return null;
    }

    /**
     * Marquer l'alerte comme résolue
     */
    public function resoudre()
    {
        $this->update([
            'statut' => 'resolue',
            'resolved_at' => now(),
        ]);
    }

    /**
     * Marquer l'alerte comme ignorée
     */
    public function ignorer()
    {
        $this->update([
            'statut' => 'ignoree',
        ]);
    }

    /**
     * Scope pour les alertes actives
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    /**
     * Scope pour les alertes résolues
     */
    public function scopeResolue($query)
    {
        return $query->where('statut', 'resolue');
    }

    /**
     * Obtenir le nom complet du produit/variante
     */
    public function getNomComplet()
    {
        if ($this->variante) {
            return $this->variante->getNomComplet();
        }
        
        return $this->produit->nom;
    }
}
