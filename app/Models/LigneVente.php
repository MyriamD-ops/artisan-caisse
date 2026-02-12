<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneVente extends Model
{
    use HasFactory;

    protected $table = 'lignes_vente';

    protected $fillable = [
        'vente_id',
        'produit_id',
        'variante_id',
        'quantite',
        'prix_unitaire',
        'sous_total',
        'remise',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'sous_total' => 'decimal:2',
        'remise' => 'decimal:2',
    ];

    // ===== RELATIONS =====

    /**
     * La vente à laquelle appartient cette ligne
     */
    public function vente()
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }

    /**
     * Le produit vendu
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * La variante vendue (si applicable)
     */
    public function variante()
    {
        return $this->belongsTo(Variante::class, 'variante_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Calculer le sous-total
     */
    public function calculerSousTotal()
    {
        return ($this->prix_unitaire * $this->quantite) - $this->remise;
    }

    /**
     * Obtenir le nom du produit (avec variante si applicable)
     */
    public function getNomComplet()
    {
        if ($this->variante) {
            return $this->variante->getNomComplet();
        }
        
        return $this->produit->nom;
    }

    /**
     * Event: Avant création
     */
    protected static function boot()
    {
        parent::boot();

        // Calculer automatiquement le sous-total avant création
        static::creating(function ($ligne) {
            $ligne->sous_total = $ligne->calculerSousTotal();
        });

        // Mettre à jour le sous-total avant modification
        static::updating(function ($ligne) {
            $ligne->sous_total = $ligne->calculerSousTotal();
        });
    }
}
