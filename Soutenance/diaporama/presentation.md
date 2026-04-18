# Présentation Soutenance — SamyDessert
**Samy Ben Hamida — 2026**

---

## Slide 1 — Titre

**SamyDessert**
Boutique en ligne de pâtisseries artisanales

> Samy Ben Hamida
> Développeur Web — Formation [nom de ta formation]
> Avril 2026

---

## Slide 2 — Sommaire

1. Contexte & Analyse des besoins
2. Design & Identité visuelle
3. Stack & Architecture technique
4. Fonctionnalités
5. Qualité & Sécurité
6. Déploiement & Organisation
7. Bilan & Perspectives

---

## Slide 3 — Présentation du projet

**C'est quoi SamyDessert ?**

Une boutique en ligne de pâtisseries artisanales permettant à des clients de :
- Parcourir un catalogue de produits et recettes
- Ajouter des produits au panier
- Passer commande et payer en ligne (Stripe)
- Recevoir une confirmation par email avec facture PDF

> Projet de formation — simulation d'un site e-commerce professionnel

---

## Slide 4 — Benchmark & Inspiration

**Analyse de sites concurrents avant de commencer**

Sites étudiés : Angelina Paris, La Maison du Chocolat, Pierre Hermé

Points retenus :
- Mise en avant visuelle des produits (grandes photos)
- Navigation claire par catégorie
- Identité visuelle forte et cohérente

*[insérer capture Inspiration.png]*

---

## Slide 5 — Personas

**Qui sont les utilisateurs cibles ?**

*[insérer captures personna1.png + personna2.png]*

| Persona | Profil | Besoin |
|---------|--------|--------|
| Marie, 34 ans | Cliente régulière | Commander facilement depuis mobile |
| Thomas, 28 ans | Passionné de cuisine | Découvrir des recettes et acheter les ingrédients |

---

## Slide 6 — User Flow

**Parcours utilisateur principal**

Accueil → Catalogue → Fiche produit → Panier → Commande → Paiement → Email de confirmation

*[insérer capture userFlow.png]*

---

## Slide 7 — Wireframe

**Maquettes basse fidélité réalisées avant le développement**

Permet de valider la structure des pages avant de coder :
- Disposition des éléments
- Navigation
- Hiérarchie de l'information

*[insérer capture wireframeLow.png]*

---

## Slide 8 — Identité visuelle & Design system

**Logo** — "S" stylisé, conçu avec Affinity Designer

**Palette de couleurs :**
- Chocolat `#3B1F0E` — textes, fonds sombres
- Framboise `#C0392B` — CTA, accents
- Pistache `#7BAE7F` — badges, succès
- Crème `#FDF6EC` — fond principal

**Design system :**
- Tokens CSS dans `app.css`
- Composants réutilisables : `btn-cta`, `nav-link`, `section-title`...
- Atomic Design : Atoms → Molecules → Organisms

*[insérer captures LogoAffinityDesigner.png + PaletteTokenFigma.png]*

---

## Slide 9 — Responsive Design & Accessibilité

**Mobile-first avec Tailwind CSS v4**

3 breakpoints testés : Mobile / Tablette / Desktop

Accessibilité :
- Contraste vérifié (BlooAI) — conformité WCAG
- Police Luciole (dyslexie)
- Focus visible sur tous les éléments interactifs

*[insérer captures grilleProduitMobile.png + grilleProduitTablette.png + grilleProduitDesktop.png + contrastColorable.png]*

---

## Slide 10 — Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | PHP 8.3 + Symfony 7.4 |
| Frontend | Twig + Tailwind CSS v4 + Stimulus |
| Temps réel | Symfony UX Live Components (Turbo) |
| Base de données | MySQL 8.0 + Doctrine ORM |
| Paiement | Stripe (Checkout + Webhooks) |
| Emails | Resend API |
| Déploiement | Docker + Railway |
| Assets | AssetMapper + ImportMap |

---

## Slide 11 — Architecture MVC

**Pattern : MVC (Model View Controller)**

```
Requête HTTP → Router → Controller → Service → Entity
                                ↓                  ↓
                           Twig (View)        Repository (DB)
```

- **Models** : entités Doctrine (`Produit`, `Commande`, `Utilisateur`...)
- **Views** : templates Twig + composants atomiques
- **Controllers** : logique métier légère, délèguent aux Services

*[insérer capture MVC.png]*

---

## Slide 12 — Structure du projet

**Architecture Atomic Design**

Les composants UI sont organisés du plus simple au plus complexe :
- **Atoms** : bouton, lien, badge, input
- **Molecules** : carte produit, bouton panier, notation étoiles
- **Organisms** : header, footer, grille produits, panier live

*[insérer captures arborescenceProjet.png + atomicDesignFichiers.png]*

---

## Slide 13 — Base de données

**9 entités principales :**

`Utilisateur` · `Produit` · `Recette` · `Commande` · `CommandeProduit` · `Panier` · `PanierProduit` · `Avis` · `Favori`

Points clés :
- Prix en `DECIMAL(8,2)` — pas de float (erreurs d'arrondi)
- Prix dupliqué dans `CommandeProduit` — historique fiable
- Enums PHP natifs (`StatutCommande`, `Difficulté`)

*[insérer capture DBdiagram.png]*

---

## Slide 14 — Fonctionnalités : Catalogue & Recettes

**Catalogue produits**
- Filtres par catégorie, tri par prix/note
- Turbo Frames — navigation sans rechargement
- Zoom image au clic
- Système de favoris (AJAX)

**Section recettes**
- Grille responsive identique aux produits

*[insérer captures grilleProduitDesktop.png + ReccetteGrid.png]*

---

## Slide 15 — Fonctionnalités : Panier

**Sidebar panier persistante**
- Ouverture/fermeture via Stimulus
- Mise à jour en temps réel (Live Component)
- Ajout / retrait / suppression de produits
- Confirmation avant vidage (dialog natif HTML)

*[insérer captures modalPanier.png + PanierAjouterSupprimer.png + ConfirmationViderPanier.png]*

---

## Slide 16 — Fonctionnalités : Commande & Paiement

**Tunnel de commande**
1. Récapitulatif panier
2. Redirection vers Stripe Checkout
3. Webhook Stripe → mise à jour statut commande
4. Email de confirmation + facture PDF

**Stripe en mode test :**
- Carte : `4242 4242 4242 4242`
- Webhook idempotent — protection contre les doublons

*[insérer capture panier2.png]*

---

## Slide 17 — Fonctionnalités : Emails transactionnels

**4 emails automatiques :**

| Déclencheur | Email envoyé |
|-------------|-------------|
| Inscription | Lien de vérification |
| Compte vérifié | Email de bienvenue |
| Commande confirmée | Confirmation + facture PDF |
| Commande annulée | Notification d'annulation |

**Service :** Resend API (domaine `samydessert.fr` vérifié)

---

## Slide 18 — Fonctionnalités : Administration

**Interface EasyAdmin**
- Gestion produits, recettes, commandes, utilisateurs, avis
- Upload d'images via VichUploader (stockage local)
- Accès réservé `ROLE_ADMIN`

**Système d'avis**
- Note 1-5 étoiles, note moyenne calculée dynamiquement
- Un seul avis par utilisateur par produit

*[insérer captures easyadmin.png + adminListeProduits.png + adminEditionProduit.png + vichuploader.png]*

---

## Slide 19 — Détails UX

**Soins apportés à l'expérience utilisateur**

- Focus visible sur les inputs (accessibilité clavier)
- Messages d'erreur clairs sur le formulaire de connexion
- Bouton panier animé (feedback visuel immédiat)

*[insérer captures InputFocus.png + ConnexionErreur.png + boutonPanier.png]*

---

## Slide 20 — Sécurité

| Menace | Protection |
|--------|-----------|
| CSRF | Token Symfony sur tous les formulaires |
| XSS | Échappement automatique Twig |
| Injection SQL | Doctrine ORM (requêtes préparées) |
| Accès non autorisé | Voters + `ROLE_ADMIN` / `ROLE_USER` |
| Mots de passe | Hachage automatique Symfony (`auto`) — Sodium/bcrypt |
| Données de paiement | Jamais stockées — délégation à Stripe |

*[insérer capture securiteYaml.png]*

---

## Slide 21 — Code PHP

**Exemple : entité Produit & tokens CSS**

- Attributs Doctrine pour le mapping BDD
- VichUploader pour la gestion des images
- Tokens CSS dans `app.css` pour le design system

*[insérer captures ProduitPHP.png + appCSS.png]*

---

## Slide 22 — Tests

**PHPUnit — Tests unitaires et fonctionnels**

- `PanierServiceTest` — ajout, suppression, calcul total
- `CommandeControllerTest` — tunnel de commande
- `ContactControllerTest` — validation formulaire

Résultats : **XX tests, XX assertions, 0 erreurs**

*[insérer captures PHPunit.png + TESTunit74.png]*

---

## Slide 23 — Déploiement

**Environnement de développement**
- Docker Compose — 6 services (nginx, php-fpm, mysql, adminer, init, assets)
- Pas d'installation locale requise

**Production — Railway**
- Déploiement automatique sur push `main`
- 1 container Docker (Dockerfile à la racine)
- Variables sensibles dans Railway (jamais commitées)
- URL : `https://samydessert-production.up.railway.app`

---

## Slide 24 — Gestion de version avec Git

**Stratégie de branches**

| Branche | Rôle |
|---------|------|
| `dev` | Développement quotidien |
| `main` | Code stable → déploiement Railway automatique |

**Convention de commits :** Conventional Commits
- `feat:` nouvelle fonctionnalité
- `fix:` correction de bug
- `docs:` documentation
- `refactor:` refactoring

---

## Slide 25 — Veille technologique

**Comment je me tiens informé**

- Stack Overflow, GitHub Issues — résolution de problèmes concrets
- YouTube (Grafikart, Symfony Online Conference) — démonstrations visuelles
- **IA (Claude, ChatGPT)** — compréhension rapide, vérification des réponses

**Technologies récentes adoptées dans ce projet**

| Technologie | Nouveauté |
|-------------|-----------|
| Symfony 7.4 | Live Components, UX Twig Components |
| Tailwind CSS v4 | Tokens CSS natifs, pas de `tailwind.config.js` |
| PHP 8.3 | Enums natifs, readonly properties |
| Resend API | Alternative moderne à SMTP pour les emails en prod |
| AssetMapper | Remplace Webpack Encore — zéro configuration |

---

## Slide 26 — Difficultés rencontrées

| Difficulté | Solution |
|------------|---------|
| Webhook Stripe en local | Stripe CLI (`stripe listen`) |
| Emails bloqués depuis Railway | Migration SMTP → Resend API (HTTP) |
| Tailwind watch sur Docker Windows | Script de recompilation toutes les 3s |
| Turbo Frames & rechargement partiel | Identification précise des frames Turbo |
| VichUploader + AssetMapper | Configuration manuelle du mapping |

---

## Slide 27 — Améliorations futures

**Fonctionnalités**
- Ingrédients dans les recettes
- Modération des avis avant publication
- Variations de produits (taille, parfum)
- Recettes proposées par les utilisateurs

**Technique**
- Remplacer `php -S` par Nginx + PHP-FPM en prod
- Token de vérification email avec expiration
- Token CSRF sur les actions AJAX (favoris)
- Internationalisation (symfony/translation)

---

## Slide 28 — Démonstration live

**Démonstration sur le site en production**

🔗 `https://samydessert-production.up.railway.app`

Parcours prévu :
1. Accueil → catalogue → fiche produit
2. Ajout au panier → commande → paiement Stripe
3. Interface admin

> Comptes de démonstration :
> - Admin : `samy@admin.com` / `password123`
> - Utilisateur : `test@test.com` / `password123`

---

## Slide 29 — Bilan personnel

**Ce que j'ai appris**

- Structurer un projet Symfony de A à Z
- Travailler avec Docker en environnement de dev
- Intégrer des services tiers (Stripe, Resend, VichUploader)
- Utiliser l'IA comme outil d'apprentissage — poser les bonnes questions, vérifier les réponses
- Déployer en production sur Railway
- Concevoir une identité visuelle cohérente (logo, palette, design system) avec Affinity Designer et Figma
- Appliquer les principes d'accessibilité web (contraste WCAG, police Luciole, focus clavier)
- Découper un projet en tâches et responsabilités claires — chaque Controller, Service et composant a un rôle unique

**Ce qui m'a le plus apporté**
> Voir un projet passer d'une idée à un produit réel, en ligne, utilisable — et comprendre chaque brique qui le compose.

---

## Slide 30 — Questions

**Merci !**

SamyDessert — Boutique en ligne de pâtisseries artisanales

🔗 `https://samydessert-production.up.railway.app`

*Prêt pour vos questions*
