# 📦 MODÈLES ELOQUENT - Artisan Caisse

## ✅ Modèles créés (11 au total)

Tous les modèles Eloquent ont été créés avec toutes les relations et méthodes utiles.

---

## 📁 Liste des modèles

### 1. **Utilisateur** (`app/Models/Utilisateur.php`)
**Table** : `utilisateurs`

**Relations** :
- `ventes()` → hasMany Vente
- `mouvementsStock()` → hasMany MouvementStock

**Méthodes utiles** :
- `isAdmin()` : Vérifier si admin
- `getTotalVentes()` : CA total généré
- `getNombreVentes()` : Nombre de ventes

---

### 2. **Produit** (`app/Models/Produit.php`)
**Table** : `produits`

**Relations** :
- `images()` → hasMany ImageProduit
- `imagePrincipale()` → hasOne ImageProduit
- `variantes()` → hasMany Variante
- `lignesVente()` → hasMany LigneVente
- `mouvementsStock()` → hasMany MouvementStock
- `alertesStock()` → hasMany AlerteStock

**Méthodes utiles** :
- `getStockTotal()` : Stock total toutes variantes
- `hasStock()` : Vérifier disponibilité
- `getTotalVentes()` : Nombre total de ventes
- `scopeActif()` : Filtrer produits actifs
- `scopeCategorie()` : Filtrer par catégorie

---

### 3. **ImageProduit** (`app/Models/ImageProduit.php`)
**Table** : `images_produit`

**Relations** :
- `produit()` → belongsTo Produit

**Méthodes utiles** :
- `getUrlComplete()` : URL complète de l'image

---

### 4. **Variante** (`app/Models/Variante.php`)
**Table** : `variantes`

**Relations** :
- `produit()` → belongsTo Produit
- `lignesVente()` → hasMany LigneVente
- `mouvementsStock()` → hasMany MouvementStock
- `alertesStock()` → hasMany AlerteStock

**Méthodes utiles** :
- `getPrixFinal()` : Prix base + ajustement
- `getNomComplet()` : Nom avec taille/couleur/matière
- `hasStock()` : Vérifier stock disponible
- `getTotalVentes()` : Nombre de ventes
- `incrementStock($quantite)` : Ajouter du stock
- `decrementStock($quantite)` : Retirer du stock

---

### 5. **Evenement** (`app/Models/Evenement.php`)
**Table** : `evenements`

**Relations** :
- `ventes()` → hasMany Vente

**Méthodes utiles** :
- `getChiffreAffaires()` : CA total de l'événement
- `getNombreVentes()` : Nombre de ventes
- `isEnCours()` : Événement en cours
- `isPasse()` : Événement passé
- `isAvenir()` : Événement à venir
- `getDureeJours()` : Durée en jours
- `scopeEnCours()` : Filtrer événements en cours
- `scopeAvenir()` : Filtrer événements futurs
- `scopePasse()` : Filtrer événements passés

---

### 6. **Vente** (`app/Models/Vente.php`)
**Table** : `ventes`

**Relations** :
- `utilisateur()` → belongsTo Utilisateur
- `evenement()` → belongsTo Evenement
- `lignes()` → hasMany LigneVente

**Méthodes utiles** :
- `getNombreArticles()` : Nombre total d'articles
- `calculerMontantTotal()` : Calculer le total
- `marquerSynchronisee()` : Marquer comme synchro
- `genererNumeroVente()` : Générer numéro unique (static)
- `scopeNonSynchronisees()` : Filtrer non synchro
- `scopeModePaiement()` : Filtrer par paiement
- `scopeAujourdhui()` : Ventes du jour

---

### 7. **LigneVente** (`app/Models/LigneVente.php`)
**Table** : `lignes_vente`

**Relations** :
- `vente()` → belongsTo Vente
- `produit()` → belongsTo Produit
- `variante()` → belongsTo Variante

**Méthodes utiles** :
- `calculerSousTotal()` : Calcul automatique
- `getNomComplet()` : Nom produit + variante

**Events** :
- Auto-calcul du sous-total à la création/modification

---

### 8. **MouvementStock** (`app/Models/MouvementStock.php`)
**Table** : `mouvements_stock`

**Relations** :
- `produit()` → belongsTo Produit
- `variante()` → belongsTo Variante
- `utilisateur()` → belongsTo Utilisateur

**Méthodes utiles** :
- `creerEntree()` : Créer entrée stock (static)
- `creerSortie()` : Créer sortie stock (static)
- `scopeType()` : Filtrer par type
- `scopeEntrees()` : Filtrer entrées
- `scopeSorties()` : Filtrer sorties

---

### 9. **AlerteStock** (`app/Models/AlerteStock.php`)
**Table** : `alertes_stock`

**Relations** :
- `produit()` → belongsTo Produit
- `variante()` → belongsTo Variante

**Méthodes utiles** :
- `verifierEtCreer()` : Créer alerte si stock bas (static)
- `resoudre()` : Marquer comme résolue
- `ignorer()` : Marquer comme ignorée
- `scopeActive()` : Filtrer alertes actives
- `scopeResolue()` : Filtrer alertes résolues
- `getNomComplet()` : Nom produit/variante

---

### 10. **Parametre** (`app/Models/Parametre.php`)
**Table** : `parametres`

**Méthodes utiles** :
- `get($cle, $default)` : Obtenir valeur (static)
- `set($cle, $valeur, $description)` : Définir valeur (static)
- `has($cle)` : Vérifier existence (static)
- `remove($cle)` : Supprimer paramètre (static)
- `getAllAsArray()` : Tous en tableau (static)

**Usage** :
```php
Parametre::set('nom_boutique', 'Atelier Doré');
$nom = Parametre::get('nom_boutique', 'Boutique par défaut');
```

---

### 11. **LogSynchronisation** (`app/Models/LogSynchronisation.php`)
**Table** : `logs_synchronisation`

**Méthodes utiles** :
- `logSucces($type, $nombre)` : Logger succès (static)
- `logEchec($type, $message, $nombre)` : Logger échec (static)
- `logPartiel($type, $nombre, $message)` : Logger partiel (static)
- `scopeType()` : Filtrer par type
- `scopeStatut()` : Filtrer par statut
- `scopeSucces()` : Filtrer succès
- `scopeEchec()` : Filtrer échecs
- `derniere($type)` : Dernière synchro (static)
- `tauxSucces($type)` : Taux de succès % (static)

**Usage** :
```php
LogSynchronisation::logSucces('ventes', 15);
LogSynchronisation::logEchec('produits', 'Erreur réseau');
$taux = LogSynchronisation::tauxSucces('ventes'); // 95.5
```

---

## 📊 Schéma des relations

```
UTILISATEUR (1,N) ──> VENTE
UTILISATEUR (1,N) ──> MOUVEMENT_STOCK

PRODUIT (1,N) ──> IMAGE_PRODUIT
PRODUIT (1,N) ──> VARIANTE
PRODUIT (1,N) ──> LIGNE_VENTE
PRODUIT (1,N) ──> MOUVEMENT_STOCK
PRODUIT (1,N) ──> ALERTE_STOCK

VARIANTE (1,N) ──> LIGNE_VENTE
VARIANTE (1,N) ──> MOUVEMENT_STOCK
VARIANTE (1,N) ──> ALERTE_STOCK

EVENEMENT (1,N) ──> VENTE

VENTE (1,N) ──> LIGNE_VENTE
```

---

## 🎯 Exemples d'utilisation

### Créer un produit avec variantes

```php
$produit = Produit::create([
    'nom' => 'Boucles d\'oreilles Perles',
    'description' => 'Magnifiques boucles d\'oreilles',
    'categorie' => 'Boucles d\'oreilles',
    'prix_base' => 49.90,
    'actif' => true,
]);

// Ajouter des variantes
$produit->variantes()->create([
    'couleur' => 'Or',
    'stock_quantite' => 10,
]);

$produit->variantes()->create([
    'couleur' => 'Argent',
    'stock_quantite' => 5,
    'ajustement_prix' => -5.00,
]);
```

### Créer une vente

```php
$vente = Vente::create([
    'numero_vente' => Vente::genererNumeroVente(),
    'utilisateur_id' => 1,
    'evenement_id' => 2,
    'montant_total' => 0, // Sera calculé
    'mode_paiement' => 'carte',
    'date_vente' => now(),
]);

// Ajouter des lignes
$vente->lignes()->create([
    'produit_id' => 1,
    'variante_id' => 1,
    'quantite' => 2,
    'prix_unitaire' => 49.90,
]);

// Recalculer le total
$vente->montant_total = $vente->calculerMontantTotal();
$vente->save();
```

### Gérer le stock

```php
// Créer un mouvement d'entrée
MouvementStock::creerEntree(
    produit_id: 1,
    variante_id: 1,
    quantite: 20,
    utilisateur_id: 1,
    notes: 'Réapprovisionnement'
);

// Mettre à jour le stock
$variante = Variante::find(1);
$variante->incrementStock(20);

// Vérifier et créer une alerte
AlerteStock::verifierEtCreer(1, 1, $variante->stock_quantite, 5);
```

### Statistiques

```php
// CA d'un événement
$event = Evenement::find(1);
$ca = $event->getChiffreAffaires();

// Ventes d'aujourd'hui
$ventes = Vente::aujourdhui()->get();

// Alertes actives
$alertes = AlerteStock::active()->with('produit', 'variante')->get();

// Taux de synchro
$taux = LogSynchronisation::tauxSucces('ventes');
```

---

## 🚀 Prochaines étapes

1. ✅ Migrations créées
2. ✅ Modèles créés avec relations
3. ⏭️ Créer les seeders de test
4. ⏭️ Installer et configurer Filament
5. ⏭️ Créer les Resources Filament
6. ⏭️ Développer l'API REST

---

**Tous les modèles sont prêts ! 🎉**
