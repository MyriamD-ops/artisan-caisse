<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'username',
        'pin_hash',
        'fingerprint_id',
        'role',
        'last_login',
    ];

    protected $hidden = [
        'pin_hash',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    // ===== RELATIONS =====

    /**
     * Les ventes effectuées par cet utilisateur
     */
    public function ventes()
    {
        return $this->hasMany(Vente::class, 'utilisateur_id');
    }

    /**
     * Les mouvements de stock effectués par cet utilisateur
     */
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class, 'utilisateur_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier si l'utilisateur est administrateur
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Obtenir le CA total généré par cet utilisateur
     */
    public function getTotalVentes()
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
}
