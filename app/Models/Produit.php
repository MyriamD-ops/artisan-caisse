<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';

    protected $fillable = [
        'nom',
        'description',
        'categorie',
        'prix_base',
        'code_barres',
        'qr_code',
        'actif',
    ];

    protected $casts = [
        'prix_base' => 'decimal:2',
        'actif' => 'boolean',
    ];

    // ===== RELATIONS =====

    /**
     * Les images du produit
     */
    public function images()
    {
        return $this->hasMany(ImageProduit::class, 'produit_id')
            ->orderBy('ordre_affichage');
    }

    /**
     * L'image principale du produit
     */
    public function imagePrincipale()
    {
        return $this->hasOne(ImageProduit::class, 'produit_id')
            ->where('est_principale', true);
    }

    /**
     * Les variantes du produit
     */
    public function variantes()
    {
        return $this->hasMany(Variante::class, 'produit_id');
    }

    /**
     * Les lignes de vente contenant ce produit
     */
    public function lignesVente()
    {
        return $this->hasMany(LigneVente::class, 'produit_id');
    }

    /**
     * Les mouvements de stock de ce produit
     */
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class, 'produit_id');
    }

    /**
     * Les alertes de stock pour ce produit
     */
    public function alertesStock()
    {
        return $this->hasMany(AlerteStock::class, 'produit_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir le stock total (toutes variantes confondues)
     */
    public function getStockTotal()
    {
        return $this->variantes()->sum('stock_quantite');
    }

    /**
     * Vérifier si le produit a du stock disponible
     */
    public function hasStock(): bool
    {
        return $this->getStockTotal() > 0;
    }

    /**
     * Obtenir le nombre total de ventes
     */
    public function getTotalVentes()
    {
        return $this->lignesVente()->sum('quantite');
    }

    /**
     * Scope pour les produits actifs
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope par catégorie
     */
    public function scopeCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }
}
