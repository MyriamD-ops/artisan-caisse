<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduit extends Model
{
    use HasFactory;

    protected $table = 'images_produit';

    protected $fillable = [
        'produit_id',
        'url_image',
        'est_principale',
        'ordre_affichage',
    ];

    protected $casts = [
        'est_principale' => 'boolean',
    ];

    // ===== RELATIONS =====

    /**
     * Le produit auquel appartient cette image
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Obtenir l'URL complète de l'image
     */
    public function getUrlComplete()
    {
        // Si l'URL est déjà complète
        if (filter_var($this->url_image, FILTER_VALIDATE_URL)) {
            return $this->url_image;
        }
        
        // Sinon, construire le chemin depuis storage
        return asset('storage/' . $this->url_image);
    }
}
