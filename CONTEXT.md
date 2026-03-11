# Contexte du projet — samyDessert

> À lire au début de chaque session pour se remettre dans le contexte.
> Mettre à jour à chaque avancée significative.

---

## État du projet

Projet de fin d'études — site de pâtisserie artisanale.
Soutenance à venir.

---

## Ce qui est fait

### Frontend
- Page d'accueil complète (`templates/home/index.html.twig`)
  - Hero section
  - Carousel "Comment ça marche" (Stimulus controller)
  - Section produits phares (`ProductCardGrid`)
  - Section nos valeurs
  - Section témoignages
  - CTA newsletter
- Composants Atomic Design : Atoms, Molecules, Organisms
- Carousel Stimulus (`assets/controllers/carousel_controller.js`)
- Tailwind v4 avec `@theme` (palette amber/marron dans `assets/styles/app.css`)

### Base de données
- Toutes les entités créées et migrées :
  - `Categorie`, `Produit`, `Utilisateur`, `Recette`
  - `Commande`, `CommandeProduit` (pivot avec clé composite)
  - `Avis` (contrainte unique utilisateur+produit)
- Enums PHP : `App\Enum\Difficulte`, `App\Enum\StatutCommande`
- Relations : ManyToMany favoris (utilisateur ↔ produit, utilisateur ↔ recette)
- Fixtures installées (`doctrine/doctrine-fixtures-bundle`)
  - Données dans `src/DataFixtures/AppFixtures.php`
  - Charger : `php bin/console doctrine:fixtures:load`

### Entité Utilisateur
- Propriété : `$password` (pas `$motDePasse`)
- Méthode : `setPassword()` / `getPassword()`
- Implémente `UserInterface` + `PasswordAuthenticatedUserInterface`

---

## Ce qui reste à faire

- [ ] Page `/produits` branchée sur la BDD
- [ ] Page `/recettes`
- [ ] Page `/contact` avec formulaire
- [ ] Authentification (`security.yaml` + page `/connexion`)
- [ ] Page `/panier` (session)
- [ ] Commenter le code pour la soutenance

---

## Commandes importantes

```bash
symfony serve                              # lancer le serveur
php bin/console tailwind:build --watch    # CSS en temps réel
php bin/console asset-map:compile         # compiler JS (obligatoire après modif JS sur Laragon)
php bin/console doctrine:fixtures:load    # recharger les données de test
php bin/console doctrine:schema:validate  # vérifier la BDD
php bin/console make:migration            # générer une migration
php bin/console doctrine:migrations:migrate # appliquer les migrations
```

---

## Stack & conventions clés

- **Symfony** + **Twig** + **Tailwind v4** + **Stimulus** + **Symfony UX Twig Components**
- Serveur local : **Laragon** (sert `public/assets/`, pas `assets/` directement)
- DB : MySQL — `samyDessert` — `.env.local` avec `DATABASE_URL`
- Atomic Design : `atoms/` → `molecules/` → `organisms/`
- `this.` uniquement pour les getters PHP dans Twig
- Après modif JS → toujours `asset-map:compile`
- Après modif CSS → toujours `tailwind:build`
