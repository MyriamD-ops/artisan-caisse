<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $table = 'ventes';

    protected $fillable = [
        'numero_vente',
        'utilisateur_id',
        'evenement_id',
        'montant_total',
        'mode_paiement',
        'date_vente',
        'synchronisee',
        'notes',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'date_vente' => 'datetime',
        'synchronisee' => 'boolean',
    ];

    // ===== RELATIONS =====

    /**
     * L'utilisateur qui a effectué la vente
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    /**
     * L'événement lors duquel la vente a été effectuée
     */
    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    /**
     * Les lignes de cette vente
     */
    public function lignes()
    {
        return $this->hasMany(LigneVente::class, 'vente_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir le nombre d'articles dans la vente
     */
    public function getNombreArticles()
    {
        return $this->lignes()->sum('quantite');
    }

    /**
     * Calculer le montant total de la vente
     */
    public function calculerMontantTotal()
    {
        return $this->lignes()->sum('sous_total');
    }

    /**
     * Marquer la vente comme synchronisée
     */
    public function marquerSynchronisee()
    {
        $this->update(['synchronisee' => true]);
    }

    /**
     * Générer un numéro de vente unique
     */
    public static function genererNumeroVente(): string
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return sprintf('VT-%s-%04d', $date, $count);
    }

    /**
     * Scope pour les ventes non synchronisées
     */
    public function scopeNonSynchronisees($query)
    {
        return $query->where('synchronisee', false);
    }

    /**
     * Scope pour les ventes par mode de paiement
     */
    public function scopeModePaiement($query, $mode)
    {
        return $query->where('mode_paiement', $mode);
    }

    /**
     * Scope pour les ventes d'aujourd'hui
     */
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_vente', today());
    }
}
