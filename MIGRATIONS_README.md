# 📊 MIGRATIONS ARTISAN CAISSE

## ✅ Migrations installées (11 tables)

Toutes les migrations ont été créées dans `database/migrations/`

### 📁 Liste des migrations

1. **utilisateurs** - Comptes vendeurs/admin
2. **produits** - Catalogue bijoux
3. **images_produit** - Photos produits
4. **variantes** - Tailles/couleurs/matières
5. **evenements** - Foires et salons
6. **ventes** - Transactions
7. **lignes_vente** - Détails ventes
8. **mouvements_stock** - Historique stock
9. **alertes_stock** - Alertes réapprovisionnement
10. **parametres** - Configuration
11. **logs_synchronisation** - Synchro mobile

---

## 🚀 Installation

### 1. Configurer la base de données

Éditer `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artisan_caisse
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Créer la base de données

```sql
CREATE DATABASE artisan_caisse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Exécuter les migrations

```bash
php artisan migrate
```

---

## 📊 Structure de la base

### Relations principales

```
UTILISATEUR (1,N) ──> VENTE
EVENEMENT (1,N) ──> VENTE
PRODUIT (1,N) ──> VARIANTE
PRODUIT (1,N) ──> IMAGE_PRODUIT
PRODUIT (1,N) ──> MOUVEMENT_STOCK
VENTE (1,N) ──> LIGNE_VENTE
VARIANTE (1,N) ──> MOUVEMENT_STOCK
```

---

## 🔍 Commandes utiles

```bash
# Voir le statut des migrations
php artisan migrate:status

# Rollback dernière migration
php artisan migrate:rollback

# Réinitialiser toutes les migrations
php artisan migrate:fresh

# Réinitialiser + seeders
php artisan migrate:fresh --seed
```

---

## 📝 Prochaines étapes

1. ✅ Migrations créées
2. ⏭️ Créer les modèles Eloquent
3. ⏭️ Installer Filament
4. ⏭️ Créer les Resources Filament
5. ⏭️ Créer les seeders
6. ⏭️ Développer l'API REST

---

**Base de données prête ! 🎉**
