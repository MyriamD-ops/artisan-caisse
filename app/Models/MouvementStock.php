<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvements_stock';

    protected $fillable = [
        'produit_id',
        'variante_id',
        'type_mouvement',
        'variation_quantite',
        'stock_avant',
        'stock_apres',
        'reference',
        'utilisateur_id',
        'date_mouvement',
        'notes',
    ];

    protected $casts = [
        'variation_quantite' => 'integer',
        'stock_avant' => 'integer',
        'stock_apres' => 'integer',
        'date_mouvement' => 'datetime',
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

    /**
     * L'utilisateur qui a effectué le mouvement
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Créer un mouvement d'entrée de stock
     */
    public static function creerEntree($produit_id, $variante_id, $quantite, $utilisateur_id, $notes = null)
    {
        $variante = Variante::find($variante_id);
        $stock_avant = $variante ? $variante->stock_quantite : 0;
        
        return self::create([
            'produit_id' => $produit_id,
            'variante_id' => $variante_id,
            'type_mouvement' => 'entree',
            'variation_quantite' => $quantite,
            'stock_avant' => $stock_avant,
            'stock_apres' => $stock_avant + $quantite,
            'utilisateur_id' => $utilisateur_id,
            'date_mouvement' => now(),
            'notes' => $notes,
        ]);
    }

    /**
     * Créer un mouvement de sortie de stock
     */
    public static function creerSortie($produit_id, $variante_id, $quantite, $utilisateur_id, $reference = null, $notes = null)
    {
        $variante = Variante::find($variante_id);
        $stock_avant = $variante ? $variante->stock_quantite : 0;
        
        return self::create([
            'produit_id' => $produit_id,
            'variante_id' => $variante_id,
            'type_mouvement' => 'sortie',
            'variation_quantite' => -$quantite,
            'stock_avant' => $stock_avant,
            'stock_apres' => $stock_avant - $quantite,
            'reference' => $reference,
            'utilisateur_id' => $utilisateur_id,
            'date_mouvement' => now(),
            'notes' => $notes,
        ]);
    }

    /**
     * Scope par type de mouvement
     */
    public function scopeType($query, $type)
    {
        return $query->where('type_mouvement', $type);
    }

    /**
     * Scope pour les entrées
     */
    public function scopeEntrees($query)
    {
        return $query->where('type_mouvement', 'entree');
    }

    /**
     * Scope pour les sorties
     */
    public function scopeSorties($query)
    {
        return $query->where('type_mouvement', 'sortie');
    }
}
