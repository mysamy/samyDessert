# samyDessert — Site e-commerce de pâtisserie artisanale

Projet de fin d'études — Symfony 7 + Tailwind CSS v4 + Doctrine + Stripe

---

## Lancer le projet

```bash
docker compose up -d
# Site disponible sur http://localhost:8080
# Adminer (gestion BDD) sur http://localhost:8081
```

## Comptes de test

| Email | Mot de passe | Rôle |
|-------|-------------|------|
| `samy@admin.com` | `password123` | Admin |
| `test@test.com` | `password123` | Client |

---

## Explication de chaque fichier et dossier à la racine

### Dossiers principaux

| Dossier | Rôle |
|---------|------|
| `src/` | Tout le code PHP du projet : controllers, entités, services, composants Twig |
| `templates/` | Les fichiers HTML en Twig : pages, composants, emails |
| `assets/` | Les fichiers sources JS et CSS qu'on **édite** (avant compilation) |
| `public/` | Le seul dossier accessible par le navigateur. Contient `index.php` (point d'entrée de Symfony) et `assets/` (fichiers compilés) |
| `config/` | Configuration Symfony : sécurité, services, routes, bundles |
| `migrations/` | Scripts SQL générés automatiquement par Doctrine pour faire évoluer la BDD |
| `docker/` | Configuration des containers Docker (nginx et php-fpm) |
| `tests/` | Tests automatisés avec PHPUnit |
| `translations/` | Fichiers de traduction (ex: messages.fr.yaml) — vide pour l'instant |
| `bin/` | Scripts exécutables : `console` (= `php bin/console`) et `phpunit` |
| `var/` | Cache, logs, fichiers temporaires — généré automatiquement, **ignoré par Git** |
| `vendor/` | Toutes les dépendances PHP installées par Composer — **ignoré par Git** |

---

### Fichiers de configuration

| Fichier | Rôle |
|---------|------|
| `docker-compose.yml` | Définit les 5 containers Docker : `nginx` (serveur web), `php` (PHP-FPM), `mysql` (base de données), `adminer` (interface BDD), `assets` (compile Tailwind en boucle) |
| `composer.json` | Liste toutes les dépendances PHP du projet (Symfony, Doctrine, Stripe, Dompdf...) |
| `composer.lock` | Fige les versions exactes de chaque dépendance — ne jamais modifier à la main |
| `importmap.php` | Déclare les librairies JavaScript gérées par Symfony AssetMapper (Stimulus, Turbo...) |
| `symfony.lock` | Suivi des "recettes" Symfony Flex (configurations auto-installées) — ne pas toucher |
| `phpunit.dist.xml` | Configuration des tests automatisés PHPUnit (voir ci-dessous) |
| `.editorconfig` | Règles de formatage partagées entre tous les éditeurs (indentation 4 espaces, UTF-8, LF...) |

---

### Fichiers d'environnement

Ces fichiers définissent des **variables d'environnement** (connexion BDD, clés API, mode dev/prod...).
Symfony les charge dans l'ordre : `.env` → `.env.dev` → `.env.local` (le dernier écrase les précédents).

| Fichier | Committé dans Git ? | Rôle |
|---------|-------------------|------|
| `.env` | ✅ Oui | Valeurs par défaut (sans secrets). Ex: `APP_ENV=dev` |
| `.env.dev` | ✅ Oui | Surcharges spécifiques à l'environnement dev |
| `.env.local` | ❌ Non | Secrets locaux : DATABASE_URL, clés Stripe, Mailtrap. **Ne jamais committer** |
| `.env.test` | ✅ Oui | Variables pour les tests PHPUnit |

---

### Fichiers Git et éditeur

| Fichier | Rôle |
|---------|------|
| `.gitignore` | Liste les fichiers/dossiers que Git ignore (`/var/`, `/vendor/`, `.env.local`, `public/assets/`...) |
| `.vscode/` | Paramètres VS Code propres au projet (extensions recommandées, formatage...) |
| `.git/` | Dossier interne Git — contient tout l'historique des commits. Ne jamais modifier |
| `.editorconfig` | Règles de formatage partagées entre tous les éditeurs (indentation 4 espaces, UTF-8, fins de ligne LF) |

---

### Fichiers liés à Claude Code (IA)

| Fichier | Rôle |
|---------|------|
| `.claude/` | Dossier de configuration de Claude Code (l'assistant IA). Contient les paramètres, hooks et la mémoire du projet |
| `install.cmd` | Script Windows pour installer Claude Code en ligne de commande (téléchargé automatiquement — pas un fichier du projet Symfony) |

---

### Fichiers de documentation

| Fichier | Rôle |
|---------|------|
| `README.md` | Ce fichier — présentation et documentation du projet |
| `CLAUDE.md` | Conventions de développement pour l'IA (Claude Code) |
| `COURS.md` | Notes de cours : explications de chaque concept utilisé dans le projet |
| `CONTEXT.md` | Ancien fichier de contexte (remplacé par CLAUDE.md) — peut être supprimé |

---

### Tests automatisés (PHPUnit)

PHPUnit est un outil qui permet d'écrire du **code qui teste ton code**.
Au lieu de vérifier manuellement dans le navigateur après chaque modification,
tu écris des scripts qui vérifient automatiquement que tout fonctionne.

```php
// Exemple : tester que le panier fonctionne bien
class PanierServiceTest extends TestCase
{
    public function testAjouterProduit(): void
    {
        $panier->ajouter(42);
        $this->assertEquals(1, $panier->getQuantitePourProduit(42)); // ✅ ou ❌
    }
}
```

```bash
docker compose exec php php bin/phpunit   # lance tous les tests
```

**Dans ce projet :** le dossier `tests/` existe mais est vide — les tests ne sont pas encore écrits.
`phpunit.dist.xml` est le fichier de configuration au cas où on en écrirait.

---

## Pages du site

| URL | Route | Description |
|-----|-------|-------------|
| `/` | `app_home` | Page d'accueil |
| `/produits` | `app_produits` | Liste des produits avec filtre et recherche |
| `/recettes` | `app_recettes` | Liste des recettes |
| `/contact` | `app_contact` | Formulaire de contact |
| `/panier` | `app_panier_index` | Panier (Live Component) |
| `/commande` | `app_commande` | Récapitulatif avant paiement |
| `/commande/paiement` | `app_commande_paiement` | Redirection vers Stripe |
| `/commande/succes` | `app_commande_succes` | Confirmation après paiement |
| `/connexion` | `app_login` | Formulaire de connexion |
| `/inscription` | `app_register` | Formulaire d'inscription |
| `/mon-compte` | `app_compte_index` | Espace client |
| `/mon-compte/commandes` | `app_compte_commandes` | Historique des commandes |

---

## Commandes Docker utiles

```bash
# Recharger les données de test (remet la BDD à zéro)
docker compose exec php php bin/console doctrine:fixtures:load

# Appliquer les migrations (nouvelles tables ou colonnes)
docker compose exec php php bin/console doctrine:migrations:migrate

# Vider le cache Symfony
docker compose exec php php bin/console cache:clear

# Forcer la recompilation des assets (CSS + JS)
docker compose exec assets sh -c "php bin/console tailwind:build && php bin/console asset-map:compile"
```
