# src/ — Code PHP du projet

Contient toute la logique PHP de l'application Symfony.

---

## Structure

```
src/
├── Controller/       # Reçoivent les requêtes HTTP et retournent des réponses
├── Entity/           # Classes PHP qui représentent les tables de la base de données
├── Repository/       # Requêtes Doctrine pour récupérer les données
├── Service/          # Logique métier réutilisable (panier, emails, PDF)
├── DataFixtures/     # Données de test insérées avec doctrine:fixtures:load
├── Enum/             # Listes de valeurs fixes (StatutCommande, Difficulte)
├── Security/         # Vérifications personnalisées lors de la connexion
├── Twig/             # Composants Twig PHP (Atomic Design)
└── Kernel.php        # Cœur de Symfony — charge les bundles et la config
```

---

## Controllers

Un controller = une ou plusieurs pages du site.
Chaque méthode correspond à une URL (définie par `#[Route(...)]`).

| Fichier | Pages gérées |
|---------|-------------|
| `HomeController` | `/` — page d'accueil |
| `ProduitsController` | `/produits` — liste avec filtre/recherche |
| `RecettesController` | `/recettes` — liste des recettes |
| `ContactController` | `/contact` — formulaire de contact |
| `PanierController` | `/panier` — ajouter/retirer/vider |
| `CommandeController` | `/commande` — récap + Stripe + succès/annulation |
| `SecurityController` | `/connexion`, `/inscription`, `/confirmer-email` |
| `CompteController` | `/mon-compte` — profil et historique commandes |
| `Admin/` | Panel d'administration (EasyAdmin) |

---

## Entities

Chaque entité = une table MySQL. Doctrine génère les migrations automatiquement.

| Entité | Table | Description |
|--------|-------|-------------|
| `Utilisateur` | `utilisateur` | Compte client (email, password, rôles) |
| `Produit` | `produit` | Produit de la boutique (nom, prix, image) |
| `Categorie` | `categorie` | Catégorie de produits (tartes, choux...) |
| `Recette` | `recette` | Recette avec instructions et difficulté |
| `Commande` | `commande` | Commande passée par un utilisateur |
| `CommandeProduit` | `commande_produit` | Table pivot commande ↔ produit (avec quantité) |
| `Avis` | `avis` | Avis client sur un produit |

---

## Services

Les services contiennent la logique métier — ils sont injectés dans les controllers via l'injection de dépendances.

| Service | Rôle |
|---------|------|
| `PanierService` | Gère le panier stocké en session PHP |
| `MailerService` | Envoie tous les emails transactionnels (confirmation, bienvenue, annulation) |
| `FactureService` | Génère les factures en PDF avec Dompdf |

---

## Twig Components (Atomic Design)

Composants UI réutilisables, organisés en 3 niveaux :

- **Atoms** — éléments de base : `Button`, `Input`, `Label`, `Icon`, `Badge`...
- **Molecules** — combinent des atoms : `FormField`, `DessertCard`, `SearchBar`...
- **Organisms** — blocs complets : `Header`, `Footer`, `PanierLive`, `ProductCardGrid`...

Chaque composant = 1 fichier PHP (`src/Twig/Components/`) + 1 fichier Twig (`templates/components/`).
