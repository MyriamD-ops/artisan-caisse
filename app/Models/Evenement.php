<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';

    protected $fillable = [
        'nom',
        'lieu',
        'date_debut',
        'date_fin',
        'description',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    // ===== RELATIONS =====

    /**
     * Les ventes effectuées lors de cet événement
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class, 'evenement_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir le chiffre d'affaires total de l'événement
     */
    public function getChiffreAffaires()
    {
        return $this->ventes()->sum('montant_total');
    }

    /**
     * Obtenir le nombre de ventes
     */
    public function getNombreVentes()
    {
        return $this->ventes()->count();
    }

    /**
     * Vérifier si l'événement est en cours
     */
    public function isEnCours(): bool
    {
        $now = now()->toDateString();
        return $now >= $this->date_debut->toDateString() 
            && $now <= $this->date_fin->toDateString();
    }

    /**
     * Vérifier si l'événement est passé
     */
    public function isPasse(): bool
    {
        return now()->toDateString() > $this->date_fin->toDateString();
    }

    /**
     * Vérifier si l'événement est à venir
     */
    public function isAvenir(): bool
    {
        return now()->toDateString() < $this->date_debut->toDateString();
    }

    /**
     * Obtenir la durée en jours
     */
    public function getDureeJours()
    {
        return $this->date_debut->diffInDays($this->date_fin) + 1;
    }

    /**
     * Scope pour les événements en cours
     */
    public function scopeEnCours($query)
    {
        $now = now()->toDateString();
        return $query->where('date_debut', '<=', $now)
            ->where('date_fin', '>=', $now);
    }

    /**
     * Scope pour les événements à venir
     */
    public function scopeAvenir($query)
    {
        return $query->where('date_debut', '>', now()->toDateString());
    }

    /**
     * Scope pour les événements passés
     */
    public function scopePasse($query)
    {
        return $query->where('date_fin', '<', now()->toDateString());
    }
}
