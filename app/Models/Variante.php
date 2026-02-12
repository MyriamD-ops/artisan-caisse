<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    use HasFactory;

    protected $table = 'variantes';

    protected $fillable = [
        'produit_id',
        'taille',
        'couleur',
        'matiere',
        'stock_quantite',
        'ajustement_prix',
        'sku',
    ];

    protected $casts = [
        'stock_quantite' => 'integer',
        'ajustement_prix' => 'decimal:2',
    ];

    // ===== RELATIONS =====

    /**
     * Le produit auquel appartient cette variante
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * Les lignes de vente contenant cette variante
     */
    public function lignesVente()
    {
        return $this->hasMany(LigneVente::class, 'variante_id');
    }

    /**
     * Les mouvements de stock de cette variante
     */
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class, 'variante_id');
    }

    /**
     * Les alertes de stock pour cette variante
     */
    public function alertesStock()
    {
        return $this->hasMany(AlerteStock::class, 'variante_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir le prix final (prix de base + ajustement)
     */
    public function getPrixFinal()
    {
        return $this->produit->prix_base + $this->ajustement_prix;
    }

    /**
     * Obtenir le nom complet de la variante
     */
    public function getNomComplet()
    {
        $parts = array_filter([
            $this->produit->nom,
            $this->taille,
            $this->couleur,
            $this->matiere,
        ]);
        
        return implode(' - ', $parts);
    }

    /**
     * Vérifier si la variante a du stock
     */
    public function hasStock(): bool
    {
        return $this->stock_quantite > 0;
    }

    /**
     * Obtenir le nombre de ventes
     */
    public function getTotalVentes()
    {
        return $this->lignesVente()->sum('quantite');
    }

    /**
     * Incrémenter le stock
     */
    public function incrementStock(int $quantite)
    {
        $this->increment('stock_quantite', $quantite);
    }

    /**
     * Décrémenter le stock
     */
    public function decrementStock(int $quantite)
    {
        $this->decrement('stock_quantite', $quantite);
    }
}
