# Cours & Définitions — samyDessert

> Mis à jour au fil du projet. Chaque concept est expliqué dans le contexte de la stack utilisée.

---

# Commandes utiles

## Développement local (Laragon)

```bash
symfony serve                            # lance le serveur Symfony
php bin/console tailwind:build --watch   # recompile le CSS à chaque modif
php bin/console asset-map:compile        # compile les assets JS/CSS vers public/
```

## Docker

```bash
docker compose up --build    # premier lancement (construit les images)
docker compose up            # lancement normal
docker compose down          # arrêter les conteneurs
docker compose ps            # liste l'état de tous les conteneurs
docker compose logs php      # voir les logs du conteneur PHP
docker compose exec php bash # entrer dans le conteneur PHP (terminal Linux)
```

### `docker compose` vs `docker`

- `docker` gère **un seul conteneur** à la fois, manuellement
- `docker compose` gère **tous les conteneurs** définis dans `docker-compose.yml` ensemble

| Commande | Ce que ça fait |
|---|---|
| `docker compose up` | Démarre tous les services du projet |
| `docker compose down` | Arrête et supprime tous les conteneurs |
| `docker compose ps` | Liste l'état de chaque conteneur |
| `docker compose exec php ...` | Entre dans le service `php` et exécute une commande |

### Pourquoi `docker compose exec php` pour les commandes Symfony ?

PHP et MySQL tournent dans des **conteneurs Linux isolés**, pas sur Windows.
Taper `php bin/console` directement dans le terminal Windows échoue car PHP n'est pas installé localement.

`docker compose exec php` dit à Docker : *"entre dans le conteneur `php` et exécute cette commande à l'intérieur"*, là où PHP et la connexion MySQL existent.

## Symfony / Doctrine (avec Docker)

> Toutes les commandes `php bin/console` doivent passer par `docker compose exec php` quand on utilise Docker.

```bash
docker compose exec php php bin/console make:controller
docker compose exec php php bin/console make:entity
docker compose exec php php bin/console make:migration
docker compose exec php php bin/console doctrine:migrations:migrate
docker compose exec php php bin/console doctrine:schema:validate
docker compose exec php php bin/console doctrine:fixtures:load
docker compose exec php php bin/console cache:clear
```

## Assets

```bash
php bin/console tailwind:build           # (re)génère le CSS Tailwind
php bin/console tailwind:build --watch   # recompile à chaque modification
php bin/console asset-map:compile        # compile vers public/assets/ (prod)
php bin/console debug:asset-map          # liste tous les assets reconnus
```

---

# Environnement & Infrastructure

## Stack du projet

| Outil | Rôle |
|---|---|
| **Symfony** | Framework PHP — routing, contrôleurs, templates |
| **Twig** | Moteur de templates HTML |
| **Tailwind CSS v4** | CSS utilitaire — classes générées depuis `app.css` |
| **Stimulus** | JS léger — contrôleurs attachés au DOM via `data-controller` |
| **Symfony UX Twig Components** | Composants réutilisables (Atomic Design) |
| **Symfony AssetMapper** | Gestion des assets JS/CSS sans bundler (remplace Webpack) |
| **Font Awesome 7** | Bibliothèque d'icônes via classes CSS |
| **Laragon** | Serveur local Windows (Apache + PHP) |

---

## Docker

### C'est quoi Docker ?

Docker permet de faire tourner un projet dans des "boîtes" isolées appelées **conteneurs**. Chaque conteneur contient un programme + tout ce dont il a besoin pour fonctionner.

**Avantage principal :** l'environnement (PHP, MySQL, Nginx) est dans git avec le code. Sur n'importe quel PC, un seul `docker compose up` suffit — plus besoin d'installer Laragon, PHP ou MySQL manuellement.

---

### Architecture Docker du projet

```
Navigateur → http://localhost:8080
                ↓
           Nginx (conteneur)       ← reçoit la requête HTTP
                ↓
           PHP-FPM (conteneur)     ← exécute le code Symfony
                ↓
           MySQL (conteneur)       ← stocke les données
```

---

### Fichiers de configuration

```
docker-compose.yml             ← définit les 3 services à lancer
docker/nginx/default.conf      ← config du serveur web Nginx
docker/php/Dockerfile          ← config PHP 8.3 avec les extensions Symfony
```

**`docker-compose.yml`** est la pièce centrale. Il déclare :
- Nginx sur le port `8080`
- PHP 8.3-FPM avec les extensions requises
- MySQL 8.0 sur le port `3307` (pour ne pas conflicuter avec Laragon)

---

### Image vs Conteneur

| Image | Conteneur |
|-------|-----------|
| Le "modèle" (comme une classe PHP) | L'instance qui tourne (comme un objet) |
| Construite depuis un `Dockerfile` | Créée depuis une image |
| Stockée sur le disque | S'exécute en mémoire |

**Image** = la recette. Elle décrit ce qu'il faut installer (PHP 8.3, telle extension...). Elle ne tourne pas — elle existe juste sur le disque.

**Conteneur** = ce qui tourne réellement. Créé depuis une image. On peut lancer plusieurs conteneurs depuis la même image.

```
Image PHP 8.3          →   Conteneur php-1  (qui tourne)
(recette sur le disque)     Conteneur php-2  (un autre si besoin)
```

> Analogie : l'image c'est comme un moule à gâteau, le conteneur c'est le gâteau.

---

### Dockerfile

Un **Dockerfile** est un fichier texte qui décrit comment construire une image. C'est une liste d'instructions exécutées dans l'ordre :

```dockerfile
FROM php:8.3-fpm          # part de l'image officielle PHP 8.3
RUN apt-get install ...   # installe des paquets Linux
COPY --from=composer ...  # copie Composer dans l'image
WORKDIR /var/www/html     # définit le dossier de travail
```

> **Phrase clé** : Le Dockerfile décrit comment construire une image, comme une recette de cuisine.

---

### Volume

Un **volume** est un dossier partagé entre le PC hôte (Windows) et le conteneur (Linux). Sans volume, les données disparaissent quand le conteneur s'arrête.

Dans notre projet :
```yaml
volumes:
  - .:/var/www/html       # le dossier du projet Windows ↔ /var/www/html dans Linux
  - mysql_data:/var/lib/mysql  # les données MySQL survivent aux redémarrages
```

> **Phrase clé** : Un volume permet de persister des données et de partager des fichiers entre l'hôte et le conteneur.

---

### Port

Un **port** est un numéro qui identifie un service sur une machine. Docker fait le lien entre un port de ton PC et un port dans le conteneur.

```yaml
ports:
  - "8080:80"   # port 8080 du PC → port 80 du conteneur Nginx
  - "3307:3306" # port 3307 du PC → port 3306 du conteneur MySQL
```

On utilise `3307` pour MySQL (au lieu de `3306`) pour ne pas entrer en conflit avec le MySQL de Laragon qui tourne déjà sur le port `3306`.

---

### WSL2

**WSL2** (Windows Subsystem for Linux 2) est un vrai kernel Linux qui tourne directement dans Windows. Docker Desktop l'utilise pour faire tourner les conteneurs Linux sur Windows.

```
Windows
  └── WSL2 (kernel Linux)
        └── Docker
              ├── Conteneur Nginx
              ├── Conteneur PHP
              └── Conteneur MySQL
```

C'est pour ça qu'on a dû activer la **virtualisation dans le BIOS** — WSL2 en a besoin pour démarrer.

---

### PHP-FPM

**PHP-FPM** (FastCGI Process Manager) est la version de PHP optimisée pour fonctionner avec un serveur web comme Nginx. Contrairement à Apache qui intègre PHP directement, Nginx délègue l'exécution PHP à PHP-FPM via le protocole FastCGI.

```
Nginx reçoit une requête .php
  → passe à PHP-FPM via FastCGI (port 9000)
    → PHP-FPM exécute le fichier
      → renvoie le HTML à Nginx
        → Nginx renvoie au navigateur
```

---

### Nginx — C'est quoi ?

**Nginx** (prononcé "engine-x") est un **serveur web** — il reçoit les requêtes HTTP du navigateur et les transmet au bon endroit.

Dans le projet, Nginx ne comprend pas PHP — il sert d'intermédiaire entre le navigateur et PHP-FPM :

```
Navigateur → "je veux localhost:8080"
                ↓
             Nginx          ← reçoit la requête
                ↓
          "c'est un .php → je passe à PHP-FPM"
                ↓
             PHP-FPM        ← exécute Symfony
                ↓
             Nginx          ← renvoie la réponse au navigateur
```

**Laragon utilisait Apache** pour faire exactement la même chose. Nginx est juste plus léger et plus utilisé en production.

---

### Pourquoi on n'a plus besoin de Laragon avec Docker ?

Avec Docker, les 3 choses que Laragon faisait sont maintenant dans des conteneurs :

| Avant (Laragon) | Maintenant (Docker) |
|---|---|
| Apache/Nginx de Laragon | Conteneur Nginx |
| PHP de Laragon | Conteneur PHP-FPM |
| MySQL de Laragon | Conteneur MySQL |

Le site tourne sur `localhost:8080` via Docker au lieu de `localhost` via Laragon. Le code source reste le même sur le PC — Docker lit les fichiers directement depuis le dossier du projet.

---

### Pourquoi activer la virtualisation dans le BIOS ?

Docker utilise **WSL2** (un vrai Linux qui tourne dans Windows). Pour faire tourner Linux dans Windows, le processeur doit avoir une fonctionnalité appelée **virtualisation matérielle** :
- Sur AMD → **SVM Mode** (à activer dans le BIOS → Advanced → CPU Configuration)
- Sur Intel → **Intel VT-x**

C'est une option désactivée par défaut, à activer une seule fois.

---

### Problème de permissions (cache Symfony)

Quand on passe de Laragon à Docker, le cache Symfony (`var/cache/`) est créé par Windows et Docker (Linux) ne peut pas le modifier → erreur 504.

**Solution :**
```bash
docker compose exec php rm -rf var/cache
docker compose exec php mkdir -p var/cache var/log
docker compose exec php chmod -R 777 var/
```

`chmod 777` = donne tous les droits à tout le monde sur ce dossier.

---

### ARM64 vs AMD64

- **AMD64** (x86_64) → processeurs Intel et AMD classiques
- **ARM64** → puces Apple Silicon (M1/M2/M3) ou certains PC Surface

---

### Commandes Docker utiles

```bash
docker compose up --build    # premier lancement (construit les images)
docker compose up            # lancement normal
docker compose down          # arrêter les conteneurs
docker compose logs php      # voir les logs du conteneur PHP
docker compose exec php bash # entrer dans le conteneur PHP (terminal Linux)
```

> **Phrase clé** : Docker isole chaque service dans un conteneur Linux. Tous les conteneurs communiquent entre eux mais sont isolés du reste du PC.

---

### Récupérer le projet sur un nouveau PC

```bash
# 1. Cloner le code source depuis GitHub
git clone https://github.com/mysamy/samyDessert.git
cd samyDessert

# 2. Construire les images et démarrer les conteneurs
docker compose up -d --build
```

C'est tout — le conteneur `init` s'occupe automatiquement du reste (voir ci-dessous).

---

### Ordre d'exécution des conteneurs

L'ordre est défini par `depends_on` dans `docker-compose.yml` :

```
mysql          ← démarre en premier (aucune dépendance)
   ↓
php            ← attend que mysql soit démarré
nginx          ← attend que php soit démarré
adminer        ← attend que mysql soit démarré
init           ← attend que mysql soit démarré, s'exécute une fois puis s'arrête
assets         ← attend que php soit démarré, tourne en boucle
```

**Important** : `depends_on` garantit que le conteneur est **démarré**, pas qu'il est **prêt à accepter des connexions**. C'est pourquoi `init` fait un `sleep 5` — pour laisser le temps à MySQL d'être vraiment opérationnel avant de lancer les migrations.

| Conteneur | Rôle | Se relance ? |
|-----------|------|-------------|
| `mysql` | Base de données | Oui (unless-stopped) |
| `php` | Exécute Symfony | Oui |
| `nginx` | Serveur web | Oui |
| `adminer` | Interface visuelle DB | Oui |
| `init` | Setup automatique (1 fois) | **Non** (`restart: "no"`) |
| `assets` | Recompile Tailwind en boucle | Oui |

---

### Conteneur `init` — initialisation automatique

Le service `init` dans `docker-compose.yml` est un conteneur temporaire qui s'exécute **une seule fois** au démarrage pour préparer le projet. Il s'arrête tout seul après (`restart: "no"`).

```yaml
command: >
  sh -c "
    sleep 5 &&
    composer install --no-interaction &&
    php bin/console doctrine:database:create --if-not-exists &&
    php bin/console doctrine:migrations:migrate --no-interaction
  "
```

| Étape | Commande | Pourquoi |
|-------|----------|----------|
| 1 | `sleep 5` | Attend que MySQL soit prêt à accepter des connexions |
| 2 | `composer install` | Le dossier `vendor/` n'est pas sur Git — il faut le recréer |
| 3 | `doctrine:database:create --if-not-exists` | Crée la base de données vide si elle n'existe pas encore |
| 4 | `doctrine:migrations:migrate --no-interaction` | Crée les tables dans la DB sans demander confirmation |

**Sans ce conteneur**, il faudrait lancer ces 3 commandes manuellement :
```bash
docker compose exec php composer install
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate
```

**`docker compose exec php <commande>`** = exécute une commande à l'intérieur du conteneur `php` qui tourne. C'est l'équivalent de se connecter en SSH à un serveur Linux et d'y taper la commande.

---

### Pourquoi `vendor/` n'est pas sur Git ?

Le dossier `vendor/` contient toutes les bibliothèques PHP installées par Composer. Il est listé dans `.gitignore` pour deux raisons :
- Il est très lourd (des centaines de fichiers)
- Il se régénère en une commande (`composer install`) depuis `composer.lock`

`composer.lock` lui est sur Git — il fige les versions exactes à installer, garantissant que tout le monde a les mêmes dépendances.

---

# PHP

## Attribut PHP `#[...]`

Un attribut PHP est une annotation native (PHP 8+) permettant d'ajouter des **métadonnées** à une classe, une méthode, une propriété ou une fonction. Ils sont interprétés directement par PHP, pas par un parser externe.

Dans Symfony, les attributs servent à :
- définir des routes → `#[Route('/produits')]`
- configurer des composants Twig → `#[AsTwigComponent]`
- déclarer des entités Doctrine → `#[ORM\Entity]`
- ajouter des règles de validation → `#[Assert\NotBlank]`

```php
#[Route('/produits', name: 'app_produits')]
public function index(): Response { ... }
```

> **Phrase clé (examen)** : Un attribut PHP est une annotation native qui ajoute des métadonnées interprétées par PHP ou un framework.

---

## Enum PHP

### Définition

Un Enum (énumération) est un type PHP qui **restreint une valeur à une liste fixe de choix**. Apparu en PHP 8.1.

```php
enum Difficulte: string
{
    case Facile    = 'facile';
    case Moyen     = 'moyen';
    case Difficile = 'difficile';
}
```

- `string` après `:` = backed enum → chaque case a une valeur PHP stockable
- `case` = chaque valeur possible

### Utilisation

```php
// Assigner
$recette->setDifficulte(Difficulte::Facile);

// Comparer
if ($recette->getDifficulte() === Difficulte::Difficile) { ... }

// Récupérer la valeur string (pour affichage)
echo $recette->getDifficulte()->value; // "facile"

// Obtenir tous les cas
Difficulte::cases(); // [Difficulte::Facile, Difficulte::Moyen, Difficulte::Difficile]
```

### Dans Twig
```twig
{{ recette.difficulte.value }}   {# affiche "facile" #}
```

### Avec Doctrine

Doctrine stocke la valeur `string` en base (`'facile'`, `'moyen'`...) et reconvertit automatiquement en Enum à la lecture :

```php
#[ORM\Column(type: 'string', enumType: Difficulte::class)]
private ?Difficulte $difficulte = null;
```

> **Phrase clé** : Un Enum garantit qu'une valeur ne peut être que parmi un ensemble défini — PHP refuse toute autre valeur à la compilation.

---

# Symfony

## Architecture

### Controller

Un Controller est une classe qui **reçoit une requête HTTP et retourne une réponse HTTP**.

Son rôle :
- gérer les actions utilisateur
- appeler des services
- transmettre les données à la vue (template)

Il ne doit **pas** contenir de logique métier complexe — c'est le rôle des Services.

```php
// Structure mentale d'une requête Symfony
Requête HTTP
  → Router → Controller → Service (logique) → Template (vue)
  ← Réponse HTTP
```

> **Phrase clé** : Le controller orchestre la requête et la réponse ; la logique métier est dans les services.

---

### Domaine de l'application

Le domaine représente l'ensemble des **concepts métier, règles et besoins fonctionnels** d'un produit. C'est ce que fait l'application, indépendamment de la technique.

Le domaine **ne dépend pas** de :
- du framework (Symfony)
- de l'ORM (Doctrine)
- de la base de données

Structure mentale :
```
Domaine (concepts métier)
  → Entités / Services
    → Ressources API / Controllers
      → Routes
        → Endpoints
```

---

### Routing & Créer une page

1. **Contrôleur** dans `src/Controller/` :
```php
#[Route('/produits', name: 'app_produits')]
public function index(): Response
{
    return $this->render('produits/index.html.twig', [
        'categories' => $categories,
    ]);
}
```

2. **Template** dans `templates/produits/index.html.twig` :
```twig
{% extends 'base.html.twig' %}
{% block body %}
  {# contenu de la page #}
{% endblock %}
```

3. Données passées du contrôleur au template :
```php
return $this->render('page.html.twig', [
    'titre' => 'Bonjour',
    'items' => [1, 2, 3],
]);
```
```twig
{{ titre }}
{% for item in items %} ... {% endfor %}
```

---

### Commandes serveur

```bash
symfony serve       # lance le serveur Symfony (bloquant, logs visibles)
symfony serve -d    # lance en arrière-plan (mode daemon)
```

> Sur Windows, `symfony serve -d` peut bloquer les logs. Préférer `symfony serve` en développement pour voir les erreurs en temps réel.

---

## Symfony AssetMapper

Remplace Webpack/Vite. Sert les assets directement depuis `assets/` en dev, **sans outil de bundling JavaScript**.

### Fichiers clés
```
assets/app.js          → point d'entrée JS
assets/styles/app.css  → point d'entrée CSS (Tailwind)
importmap.php          → déclare les dépendances JS/CSS
```

### `importmap.php`

Équivalent de `package.json` pour Symfony AssetMapper. Déclare les dépendances et leurs versions.

```php
'@fortawesome/fontawesome-free/css/all.css' => [
    'version' => '7.1.0',
    'type' => 'css',    // injecté automatiquement par importmap('app')
],
```

Les CSS de `type: 'css'` sont injectées automatiquement via `{{ importmap('app') }}` dans le `<head>`.

### Chemins logiques

Les assets dans `assets/vendor/` ont le chemin logique `vendor/...` :
```
assets/vendor/@fortawesome/.../all.css
→ chemin logique : vendor/@fortawesome/.../all.css
→ dans Twig : asset('vendor/@fortawesome/fontawesome-free/css/all.css')
```

### Commandes utiles
```bash
php bin/console asset-map:compile      # compile vers public/assets/ (prod)
php bin/console debug:asset-map        # liste tous les assets reconnus
php bin/console tailwind:build         # (re)génère le CSS Tailwind
php bin/console tailwind:build --watch # recompile à chaque modification
```

> En production, `asset-map:compile` génère des fichiers avec hash dans `public/assets/`. En dev, les assets sont servis dynamiquement via `/_assets/`.

---

## Symfony Security

### `UserInterface`

Interface PHP que doit implémenter l'entité utilisateur pour que Symfony Security puisse l'utiliser.

Méthodes obligatoires :
```php
getUserIdentifier(): string  // identifiant unique (email ou username)
getRoles(): array            // rôles de l'utilisateur
eraseCredentials(): void     // supprime données sensibles temporaires
```

### Rôles

Les rôles sont des chaînes de caractères préfixées `ROLE_`. Symfony en reconnaît quelques-uns par défaut :

| Rôle | Signification |
|---|---|
| `ROLE_USER` | Utilisateur connecté (ajouté automatiquement) |
| `ROLE_ADMIN` | Administrateur |

La hiérarchie peut être configurée dans `security.yaml` :
```yaml
role_hierarchy:
    ROLE_ADMIN: ROLE_USER  # un admin a automatiquement ROLE_USER
```

Pour donner un rôle admin à un utilisateur :
```php
$user->setRoles(['ROLE_ADMIN']);
```

### `PasswordAuthenticatedUserInterface`

Indique que l'entité a un mot de passe hashé. Permet à Symfony de gérer le hachage automatiquement.

```php
// Dans security.yaml
password_hashers:
    App\Entity\Utilisateur:
        algorithm: auto   # bcrypt  par défaut
```

> **Règle** : ne jamais stocker un mot de passe en clair. Toujours utiliser `$passwordHasher->hashPassword($user, $plainPassword)`.

---

## Doctrine ORM

### ORM (Object-Relational Mapping)

Un ORM est une couche qui fait le **pont entre les objets PHP et les tables SQL**. Au lieu d'écrire des requêtes SQL manuellement, on manipule des objets PHP et Doctrine traduit ça en SQL.

```php
// Sans ORM (SQL brut)
$pdo->query("INSERT INTO produit (nom, prix) VALUES ('Macaron', 3.50)");

// Avec ORM Doctrine
$produit = new Produit();
$produit->setNom('Macaron')->setPrix('3.50');
$em->persist($produit);
$em->flush();
```

> **Phrase clé** : Un ORM traduit les opérations sur des objets PHP en requêtes SQL automatiquement.

---

### Entité

Une entité est une classe PHP représentant un **concept métier persisté en base de données** via l'ORM Doctrine.

| Concept ORM | Équivalent SQL |
|---|---|
| Classe | Table |
| Propriété | Colonne |
| Instance | Ligne |

```php
#[ORM\Entity]
class Produit {
    #[ORM\Id]
    #[ORM\Column]
    private string $titre;
}
```

> **Phrase clé** : Une entité représente un concept métier persisté en base via un ORM.

---

### Repository

Un Repository est une classe qui centralise les **requêtes de lecture** vers une entité. Il est injecté dans les contrôleurs pour récupérer des données.

```php
// Méthodes disponibles par défaut
$produitRepository->find(5);                    // SELECT * WHERE id = 5
$produitRepository->findAll();                  // SELECT * FROM produit
$produitRepository->findBy(['disponible' => true]);   // SELECT * WHERE disponible = 1
$produitRepository->findOneBy(['nom' => 'Macaron']);  // LIMIT 1
```

On peut aussi écrire des méthodes personnalisées avec DQL ou QueryBuilder :

```php
public function findDisponiblesByCategorie(int $categorieId): array
{
    return $this->createQueryBuilder('p')
        ->where('p.disponible = true')
        ->andWhere('p.categorie = :cat')
        ->setParameter('cat', $categorieId)
        ->getQuery()
        ->getResult();
}
```

> **Phrase clé** : Le Repository centralise les requêtes de lecture pour une entité.

---

### Relations Doctrine

| Relation | Sens | Exemple |
|---|---|---|
| `ManyToOne` | Plusieurs → un | Plusieurs `Produit` → une `Categorie` |
| `OneToMany` | Un → plusieurs | Une `Categorie` → plusieurs `Produit` |
| `ManyToMany` | Plusieurs ↔ plusieurs | `Utilisateur` ↔ `Produit` (favoris) |
| `OneToOne` | Un ↔ un | `Utilisateur` ↔ `Profil` |

**ManyToOne** (côté "plusieurs") :
```php
#[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
private ?Categorie $categorie = null;
```

**OneToMany** (côté "un") :
```php
#[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'categorie')]
private Collection $produits;
```

**ManyToMany** (génère une table pivot) :
```php
#[ORM\ManyToMany(targetEntity: Produit::class)]
#[ORM\JoinTable(name: 'utilisateur_produit_favori')]
private Collection $produitsFavoris;
```

> **Phrase clé** : Les relations Doctrine traduisent les clés étrangères SQL en associations d'objets PHP.

---

### Migrations

Une migration est un **fichier PHP versionné** qui décrit une modification du schéma de base de données. Elle permet à tous les développeurs d'avoir la même structure de BDD.

```bash
php bin/console make:migration              # génère un fichier de migration depuis les entités
php bin/console doctrine:migrations:migrate # applique les migrations en attente
php bin/console doctrine:schema:validate    # vérifie que la BDD est en sync avec les entités
```

Chaque migration génère deux méthodes :
```php
public function up(): void   // applique le changement
public function down(): void // annule le changement
```

> **Règle** : ne jamais modifier manuellement une migration déjà appliquée. Créer une nouvelle migration à la place.

---

### `persist()` et `flush()`

```php
$em->persist($produit);  // dit à Doctrine de "surveiller" cet objet
$em->flush();            // envoie TOUTES les opérations en attente à la BDD (1 transaction)
```

- `persist()` seul → rien en base
- `flush()` seul → rien si pas de `persist()`
- `persist()` + `flush()` → INSERT ou UPDATE selon si l'objet est nouveau ou existant

---

# Frontend

## Tailwind CSS v4

### `@theme` — Variables de design

Remplace `tailwind.config.js`. Tout se configure dans `assets/styles/app.css`.

```css
@theme {
  --color-accent: #d97706;   /* génère bg-accent, text-accent, border-accent... */
  --font-size-h1: 3rem;      /* génère text-h1 */
  --spacing-side: 2rem;      /* génère p-side, m-side, gap-side... */
}
```

Le préfixe `--color-` est **obligatoire** pour que Tailwind génère les classes utilitaires. Le nom après est libre.

| Préfixe | Classes générées |
|---|---|
| `--color-accent` | `bg-accent`, `text-accent`, `border-accent`, `hover:bg-accent`... |
| `--font-size-h1` | `text-h1` |
| `--spacing-side` | `p-side`, `m-side`, `gap-side`... |
| `--radius-lg` | `rounded-lg` |
| `--shadow-card` | `shadow-card` |

### `@source` — Scanner les templates (JIT)

```css
@source "../../templates/**/*.twig";
```

Tailwind scanne ces fichiers pour détecter les classes utilisées et générer **uniquement** celles-là (JIT = Just In Time). Les classes construites dynamiquement en Twig (`'bg-' ~ couleur`) ne sont **pas** détectées — il faut les écrire en entier.

### Palette du projet

| Variable | Classe Tailwind | Couleur | Équivalent amber |
|---|---|---|---|
| `--color-primary` | `bg-primary` / `text-primary` | `#92400e` | amber-800 |
| `--color-secondary` | `bg-secondary` | `#fffbeb` | amber-50 |
| `--color-accent` | `bg-accent` / `text-accent` | `#d97706` | amber-600 |
| `--color-surface` | `bg-surface` | `#fef3c7` | amber-100 |
| `--color-star` | `text-star` | `#fbbf24` | amber-400 |
| `--color-text` | `text-text` | `#78350f` | amber-900 |
| `--color-text-light` | `text-text-light` | `#b45309` | amber-700 |
| `--color-focus` | `outline-focus` | `#f59e0b` | amber-500 |

---

## Symfony UX Twig Components

### Atomic Design

Organisation des composants UI en 3 niveaux :

| Niveau | Définition | Exemples |
|---|---|---|
| **Atom** | Élément de base, simple, fermé, prévisible | `Button`, `Link`, `Icon`, `Input`, `Text` |
| **Molecule** | Assemblage d'Atoms | `FormField`, `Nav`, `CarouselCard` |
| **Organism** | Bloc complexe assemblant Molecules et Atoms | `Header`, `Footer`, `ProductCard`, `Form` |

Chaque composant = 1 fichier PHP + 1 fichier Twig :
```
src/Twig/Components/Atoms/Button.php
templates/components/atoms/Button.html.twig
```

### Utilisation dans Twig

```twig
<twig:Atoms:Button>Texte</twig:Atoms:Button>
<twig:Molecules:Nav />
<twig:Organisms:ProductCard :price="9.50" title="Macaron" />
```

Le `:` devant un attribut = la valeur est une expression évaluée (pas une chaîne brute) :

```twig
title="Bonjour"      {# string littéral "Bonjour" #}
:price="9.50"        {# float 9.50 #}
:decorative="true"   {# booléen true #}
:items="myArray"     {# variable Twig #}
```

### Props

Une **prop** est une variable publique définie dans la classe PHP du composant. Elle configure le composant.

```php
public string $label = '';      // ✅ toujours une valeur par défaut
public ?string $href = null;    // ✅ nullable si optionnel
public string $label;           // ❌ erreur PHP si non passé
```

> **Phrase clé** : Une prop configure le composant côté PHP.

### Attributs HTML

Un **attribut** correspond à un attribut HTML rendu dans le DOM (`class`, `id`, `aria-*`, `data-*`...). Tout ce qui n'est pas déclaré en PHP comme prop passe automatiquement dans `{{ attributes }}`.

> **Règle** : props = intention de configuration / attributs = résultat HTML

### `attributes` et `attributes.defaults()`

`attributes` est un objet Twig permettant d'ajouter dynamiquement des attributs HTML au composant.

`attributes.defaults()` définit des attributs **par défaut** sans empêcher leur surcharge par l'appelant. Pour `class`, les valeurs sont **fusionnées** (pas remplacées).

```twig
{# Dans le template du composant : #}
<button {{ attributes.defaults({ class: 'btn btn-primary', type: 'button' }) }}>
  {{ slot }}
</button>

{# Appel depuis l'extérieur — la class sera fusionnée : #}
<twig:Atoms:Button class="w-full">Envoyer</twig:Atoms:Button>
{# Résultat : class="btn btn-primary w-full" #}
```

> **Phrase clé** : `attributes.defaults()` définit des attributs par défaut sans empêcher leur surcharge.

### Attributs booléens HTML (`disabled`, `required`, `checked`…)

En HTML, certains attributs sont **booléens** : leur présence suffit à les activer, leur valeur ne compte pas.

```html
<input disabled>          <!-- désactivé ✅ -->
<input disabled="false">  <!-- aussi désactivé ✅ (la valeur est ignorée) -->
<input>                   <!-- pas désactivé ✅ -->
```

Dans un Twig Component, on ne peut donc pas écrire `disabled="{{ disabled }}"` — si `disabled` vaut `false`, le navigateur lirait `disabled="false"` et désactiverait quand même le champ.

La bonne approche est d'écrire l'attribut **uniquement si la prop vaut `true`** :

```twig
{% if disabled %}disabled{% endif %}
{% if required %}required{% endif %}
```

**Et pour les appeler depuis un composant parent :**

```twig
{# ✅ correct — le : indique une expression PHP (booléen true) #}
<twig:Atoms:Input name="email" :required="true" />

{# ❌ incorrect — sans :, c'est une string vide "" → falsy en PHP #}
<twig:Atoms:Input name="email" required />
```

> **Règle** : pour les props booléennes dans Twig Components, toujours préfixer avec `:` pour passer une vraie valeur PHP.

### Slot / `content`

`content` est un **slot** permettant d'injecter du contenu (texte, HTML, icônes, autres composants) dans un composant. C'est un terme technique neutre et universel.

```twig
<twig:Atoms:Button>
  <twig:Atoms:Icon name="star" />  {# injecté dans le slot du bouton #}
  Favori
</twig:Atoms:Button>
```

> **Phrase clé** : `content` est un slot technique permettant d'injecter du contenu dans un composant.

### `this.` — Getters PHP

Dans un Twig Component, `this` représente l'instance de la classe PHP du composant.

```twig
{{ title }}           {# prop publique → accès direct #}
{{ this.computedId }} {# getter getComputedId() → this. obligatoire #}
```

> Attention : à l'intérieur d'un sous-composant, `this` change de contexte. Toujours extraire en `{% set %}` avant d'entrer dans un sous-composant.

### `{% set %}` en Twig

Crée une variable Twig. Utile pour :
- renommer une variable
- transformer une valeur avant le rendu
- éviter de répéter `this.xxx` à l'intérieur d'un sous-composant

```twig
{% set logoAlt = logoAlt ?: brandLabel %}
<twig:Atoms:Link ...>
  <img alt="{{ logoAlt }}"> {# logoAlt est résolu ici, pas this.logoAlt #}
</twig:Atoms:Link>
```

> **Phrase clé** : `{% set %}` sert à préparer les valeurs avant le rendu.

### `{% block %}` en Twig

Les `{% block %}` servent à l'**héritage de templates** avec `{% extends %}`. Ils ne servent pas à la composition de composants (c'est le rôle des slots).

```twig
{# base.html.twig #}
{% block body %}{% endblock %}

{# page.html.twig #}
{% extends 'base.html.twig' %}
{% block body %}
  Contenu de la page
{% endblock %}
```

> **Phrase clé** : Les blocks servent à l'héritage de templates, pas à la composition de composants.

---

## Stimulus JS

### Qu'est-ce que Stimulus ?

Stimulus est un **framework JS léger** conçu pour enrichir du HTML existant avec des comportements JavaScript. Contrairement à React/Vue, il ne gère pas le rendu HTML — il ajoute du comportement à du HTML déjà présent dans la page.

### Contrôleur

Un contrôleur Stimulus est une classe JS liée à un élément HTML via `data-controller` :

```html
<div data-controller="carousel">...</div>
```

```js
// assets/controllers/carousel_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // appelé quand l'élément entre dans le DOM
    }
    disconnect() {
        // appelé quand l'élément quitte le DOM
    }
}
```

### Cycle de vie

| Méthode | Déclenchement |
|---|---|
| `initialize()` | Une seule fois à la création |
| `connect()` | Chaque fois que l'élément entre dans le DOM |
| `disconnect()` | Chaque fois que l'élément quitte le DOM |

### Targets et Values

**Targets** — référencent des éléments enfants :
```html
<div data-controller="nav">
    <ul data-nav-target="menu">...</ul>
</div>
```
```js
static targets = ['menu'];
// this.menuTarget → l'élément <ul>
```

**Values** — données passées depuis le HTML :
```html
<div data-controller="carousel" data-carousel-slides-value="3">
```
```js
static values = { slides: Number };
// this.slidesValue → 3
```

> **Phrase clé** : Stimulus connecte le HTML au JS via des conventions de nommage (`data-controller`, `data-*-target`).

---

## Font Awesome 7

La syntaxe a changé par rapport à FA5/FA6 :

| Version | Syntaxe valide |
|---|---|
| FA5 / FA6 | `<i class="fas fa-star"></i>` |
| FA7 | `<i class="fa-solid fa-star"></i>` ou `<i class="fas fa-star"></i>` |

Les icônes prennent la couleur du texte parent (`currentColor`). Pour coloriser avec Tailwind : `<i class="fa-solid fa-star text-star"></i>`

---

# Bonnes pratiques

## Accessibilité (ARIA)

### Rôles ARIA standardisés

Un rôle ARIA est une valeur définie par la spécification WAI-ARIA permettant de décrire la **fonction d'un élément aux technologies d'assistance** (lecteurs d'écran).

```html
role="button"
role="dialog"
role="navigation"
role="region"
```

> **Règle** : ne pas ajouter de rôle ARIA si le HTML natif fournit déjà le bon rôle. `<button>` a déjà `role="button"`, `<nav>` a déjà `role="navigation"`.

---

## Sécurité des liens externes

### `rel="noopener noreferrer"`

À toujours ajouter sur les liens `target="_blank"` :

```html
<a href="https://..." target="_blank" rel="noopener noreferrer">Lien externe</a>
```

| Attribut | Protection |
|---|---|
| `noopener` | Empêche la page cible d'accéder à `window.opener` (protection contre le **tabnabbing**) |
| `noreferrer` | Empêche l'envoi de l'URL d'origine dans le header `Referer` (vie privée) |

> **Phrase clé** : `noopener` protège la page d'origine, `noreferrer` protège les informations de navigation.

---

## Node / Dépendances JS

### `package.json`

Décrit le projet JavaScript et définit les **contraintes** de dépendances (plages de versions autorisées), les scripts npm, et les métadonnées du projet.

### `pnpm-lock.yaml` (ou `package-lock.json`)

Fige les **versions exactes** des dépendances installées. Garantit que tous les développeurs et tous les environnements (CI, prod) utilisent exactement les mêmes versions.

> **Phrase clé** : `package.json` définit les contraintes, `pnpm-lock.yaml` fige la réalité installée.

---

## Patterns à retenir

### ❌ Ne pas faire
```twig
{# href sur Button → utiliser Link #}
<twig:Atoms:Button href="/page">Lien</twig:Atoms:Button>

{# ID aléatoire dans Twig → getter PHP #}
{% set id = random() %}

{# Déclarer en PHP ce qui peut passer par attributes #}
public string $placeholder = '';

{# twig:Atoms:Nav n'existe pas #}
<twig:Atoms:Nav />
```

### ✅ À la place
```twig
{# Navigation = Link #}
<twig:Atoms:Link href="/page">Lien</twig:Atoms:Link>

{# ID calculé = getter PHP #}
public function getComputedId(): string { ... }

{# placeholder passe automatiquement via attributes #}
<twig:Atoms:Input placeholder="Votre email" />

{# Nav est une Molecule #}
<twig:Molecules:Nav />
```

---

# Référence

## Architecture des fichiers

```
samyDessert/
├── assets/
│   ├── app.js                    # point d'entrée JS + Stimulus
│   ├── styles/app.css            # Tailwind + @theme
│   └── vendor/                   # dépendances téléchargées
├── docker/
│   ├── nginx/default.conf        # config serveur web
│   └── php/Dockerfile            # config PHP 8.3
├── docker-compose.yml            # définit les 3 services Docker
├── importmap.php                 # dépendances JS/CSS (≈ package.json)
├── src/
│   ├── Controller/               # logique des pages
│   └── Twig/Components/          # composants PHP
│       ├── Atoms/
│       ├── Molecules/
│       └── Organisms/
└── templates/
    ├── base.html.twig            # layout global
    ├── components/               # templates des composants
    │   ├── atoms/
    │   ├── molecules/
    │   └── organisms/
    ├── home/index.html.twig      # page d'accueil
    └── produits/index.html.twig  # page produits
```

---

## SEO

Le **SEO** (Search Engine Optimization) désigne l'ensemble des techniques pour améliorer la position d'un site web dans les résultats des moteurs de recherche (Google, Bing...).

**Pourquoi c'est important ?**
Un site bien référencé apparaît en haut des résultats Google → plus de visiteurs sans payer de publicité.

**Les éléments SEO de base en HTML :**

```html
<!-- Titre de la page — affiché dans l'onglet et dans Google -->
<title>Tarte au citron meringuée — Samy Dessert</title>

<!-- Description — affiché sous le titre dans les résultats Google -->
<meta name="description" content="Recette de tarte au citron avec meringue légère, préparée en 1h30.">

<!-- URL propre avec slug -->
https://samydessert.fr/recettes/tarte-au-citron-meringuee
```

**En Twig/Symfony :**
```twig
{% block title %}{{ recette.titre }} — Samy Dessert{% endblock %}
```

**Ce qui aide le SEO :**
- URLs lisibles (slugs)
- Balises `<h1>`, `<h2>` bien structurées
- Images avec `alt` descriptif
- Temps de chargement rapide
- Site accessible sur mobile (responsive)

> **Phrase clé** : Le SEO, c'est optimiser son site pour que Google le comprenne et le propose en premier aux utilisateurs.

---

## Slug

Un **slug** est une version d'un texte transformée pour être utilisable dans une URL : tout en minuscules, sans accents, sans espaces (remplacés par des tirets), sans caractères spéciaux.

```
"Tarte au citron meringuée"  →  tarte-au-citron-meringuee
"Paris-Brest"                →  paris-brest
"Macarons à la framboise"    →  macarons-a-la-framboise
```

**Pourquoi utiliser un slug ?**

| Sans slug | Avec slug |
|-----------|-----------|
| `/recettes/1` | `/recettes/tarte-au-citron-meringuee` |
| URL non lisible | URL descriptive et mémorisable |
| Mauvais pour le SEO | Bon pour le référencement Google |

**En Symfony**, on stocke le slug en base de données et on l'utilise dans la route :
```php
#[Route('/recettes/{slug}', name: 'app_recette_show')]
public function show(Recette $recette): Response { ... }
```

Doctrine peut résoudre automatiquement l'entité depuis le slug grâce au `ParamConverter`.

**Génération du slug en PHP** :
```php
// Symfony fournit un composant String pour ça
use Symfony\Component\String\Slugger\AsciiSlugger;

$slugger = new AsciiSlugger('fr');
$slug = strtolower($slugger->slug('Tarte au citron meringuée'));
// → "tarte-au-citron-meringuee"
```

> **Phrase clé** : Un slug est la version URL-safe d'un texte — lisible, sans accents, sans espaces.

---

## Base de données relationnelle

### C'est quoi une base de données relationnelle ?

Une **base de données relationnelle** stocke les données dans des **tables** (comme des feuilles Excel) reliées entre elles par des **clés étrangères**. C'est le modèle utilisé par MySQL, PostgreSQL, SQLite.

```
Table produit          Table categorie
-----------            -----------
id  | nom    | cat_id  id  | nom
1   | Macaron | 2      1   | Tartes
2   | Éclair  | 1      2   | Choux
```

`cat_id` dans `produit` → pointe vers `id` dans `categorie` = **clé étrangère** (foreign key).

> **Phrase clé** : Une base de données relationnelle organise les données en tables liées par des clés étrangères.

---

### Clé primaire (Primary Key)

La **clé primaire** est l'identifiant unique d'une ligne dans une table. Elle ne peut pas être nulle ni en double.

```sql
id int [pk, increment]   -- auto-incrémentée par MySQL
```

Avec Doctrine :
```php
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;
```

---

### Clé étrangère (Foreign Key)

Une **clé étrangère** est une colonne qui pointe vers la clé primaire d'une autre table. Elle crée le lien entre deux tables.

```
produit.categorie_id → categorie.id
commande.utilisateur_id → utilisateur.id
```

Si tu essaies d'insérer un `categorie_id` qui n'existe pas dans `categorie` → MySQL refuse (intégrité référentielle).

---

### Contrainte UNIQUE

Une contrainte `UNIQUE` empêche deux lignes d'avoir la même valeur dans une colonne.

```sql
slug varchar(255) [not null, unique]
email varchar(180) [not null, unique]
```

Exemples dans notre projet :
- `utilisateur.email` → deux comptes ne peuvent pas avoir le même email
- `produit.slug` → deux produits ne peuvent pas avoir la même URL
- `avis.(utilisateur_id, produit_id)` → un utilisateur ne peut laisser qu'un seul avis par produit (contrainte unique sur la paire)

---

### Snapshot de prix

Un **snapshot** (instantané) est une **copie d'une valeur au moment d'une action**, pour la conserver même si la donnée source change plus tard.

Dans notre projet, `commande_produit.prix_unitaire` est un snapshot du prix du produit :

```
Aujourd'hui :   produit.prix = 3.50 €
                commande passée → prix_unitaire = 3.50 € (copié)

6 mois plus tard : produit.prix = 4.00 € (le prix a augmenté)
                   commande.prix_unitaire = 3.50 € (la commande garde le vieux prix ✅)
```

**Pourquoi c'est important ?**
Si on ne faisait pas de snapshot et qu'on lisait juste `produit.prix`, la facture du client changerait rétroactivement à chaque modification de prix — ce qui est faux et illégal.

> **Phrase clé** : Un snapshot est une copie d'une valeur au moment où elle est utilisée, pour la figer dans le temps.

---

### dbdiagram.io

**dbdiagram.io** est un outil en ligne pour **visualiser et documenter le schéma d'une base de données** via un langage texte simple (DBML).

```
Table produit {
  id int [pk, increment]
  nom varchar(255) [not null]
  prix decimal(8,2) [not null]
  categorie_id int [ref: > categorie.id]
}
```

- `[pk]` → clé primaire
- `[not null]` → obligatoire
- `[ref: > categorie.id]` → clé étrangère vers `categorie.id`
- `[unique]` → contrainte d'unicité

C'est le premier outil à mettre à jour quand on modifie le schéma, **avant de toucher aux entités PHP**.

---

### `decimal(8,2)` pour les prix

Les prix sont stockés en `DECIMAL` et non en `FLOAT` pour éviter les erreurs d'arrondi flottant.

```
FLOAT : 3.50 peut devenir 3.4999999...
DECIMAL(8,2) : stockage exact → toujours 3.50
```

`decimal(8,2)` = 8 chiffres au total, dont 2 après la virgule → max `999999.99`.

---

## Préfixes de commit Git

Convention utilisée pour nommer les commits de façon lisible :

| Préfixe | Usage |
|---------|-------|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `chore` | Configuration, outils, maintenance (pas de fonctionnalité) |
| `docs` | Documentation |
| `refactor` | Réécriture sans changer le comportement |
| `style` | CSS, mise en forme |

Exemple :
```bash
git commit -m "chore: configuration Docker dev (nginx, php, mysql, assets Tailwind)"
git commit -m "feat: page produits avec liste des macarons"
git commit -m "fix: correction du menu mobile sur mobile"
```

---

## Symfony Mailer + Mailpit

### Pourquoi des emails transactionnels ?

Un **email transactionnel** est un email déclenché automatiquement par une action de l'utilisateur :

| Action | Email envoyé |
|--------|-------------|
| Inscription | Bienvenue + vérification email |
| Commande passée | Confirmation avec récapitulatif |
| Mot de passe oublié | Lien de réinitialisation |

Dans notre projet : `MailerService::envoyerConfirmationCommande()` envoie le récapitulatif de commande.

---

### Symfony Mailer

**Symfony Mailer** est le composant officiel pour envoyer des emails en Symfony.

```bash
composer require symfony/mailer
```

On configure l'adresse SMTP via `MAILER_DSN` dans `.env` :

```env
# Développement (Docker) — intercepte les emails sans les envoyer
MAILER_DSN=smtp://mailpit:1025
MAILER_FROM=noreply@samydessert.fr

# Production — vrai serveur SMTP (ex : Brevo/Sendinblue)
# MAILER_DSN=smtp://user:password@smtp.brevo.com:587
```

Envoyer un email :

```php
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

$email = (new Email())
    ->from('noreply@samydessert.fr')
    ->to($utilisateur->getEmail())
    ->subject('Confirmation de commande')
    ->html($html);

$mailer->send($email);
```

---

### Mailpit — intercepteur d'emails en dev

**Mailpit** est un faux serveur SMTP qui **intercepte tous les emails** envoyés en développement. Les emails n'arrivent jamais dans de vraies boîtes mail — ils sont stockés localement et consultables via une interface web.

```
http://localhost:8025    → interface web pour lire les emails
port 1025                → SMTP utilisé par Symfony Mailer
```

**Pourquoi c'est mieux que Mailtrap ?**

| | Mailpit | Mailtrap |
|--|---------|----------|
| Internet requis | ❌ Non | ✅ Oui |
| Compte à créer | ❌ Non | ✅ Oui |
| Gratuit | ✅ Toujours | Limité en gratuit |
| Tourne dans Docker | ✅ Oui | ❌ Non |

Mailpit fonctionne **complètement hors-ligne** — pratique en démo ou sans connexion.

Configuration dans `docker-compose.yml` :

```yaml
mailpit:
  image: axllent/mailpit
  ports:
    - "8025:8025"   # interface web
    - "1025:1025"   # SMTP

php:
  depends_on:
    - mailpit
  environment:
    MAILER_DSN: "smtp://mailpit:1025"
```

---

### CSS inline pour les emails

Les clients email (Gmail, Outlook…) **ignorent les balises `<style>` et les classes CSS**. Il faut du CSS **inline** dans chaque balise HTML :

```html
<!-- ❌ Ignoré par Gmail -->
<p class="text-amber-700">Bonjour</p>

<!-- ✅ Compatible email -->
<p style="color: #b45309;">Bonjour</p>
```

**Solution : `twig/cssinliner-extra`**

Ce package Twig transforme automatiquement les classes CSS en styles inline :

```bash
docker compose exec php composer require twig/cssinliner-extra
```

On crée un fichier CSS dédié `assets/styles/email.css` avec des **valeurs hex** (les variables CSS Tailwind `--color-*` ne fonctionnent pas dans les emails) :

```css
.email-header {
    background-color: #d97706;  /* amber-600 en hex */
    color: #ffffff;
    padding: 24px;
    text-align: center;
}
```

Dans le template Twig, on applique l'inliner avec `{% apply inline_css(...) %}` :

```twig
{% apply inline_css(source('@styles/email.css')) %}
<!DOCTYPE html>
<html>
  <body>
    <div class="email-header">
      Bonjour {{ commande.utilisateur.prenom }} !
    </div>
  </body>
</html>
{% endapply %}
```

Le namespace `@styles` est configuré dans `config/packages/twig.yaml` :

```yaml
twig:
    paths:
        '%kernel.project_dir%/assets/styles': 'styles'
```

Au rendu, Twig remplace toutes les classes par leurs équivalents `style="..."` avant d'envoyer l'email.

---

### Architecture du service Mailer

On centralise tout dans `src/Service/MailerService.php` pour ne pas écrire du code email dans les controllers :

```php
class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig,
        private string $mailerFrom,
    ) {}

    public function envoyerConfirmationCommande(Commande $commande): void
    {
        $email = (new Email())
            ->from($this->mailerFrom)
            ->to($commande->getUtilisateur()->getEmail())
            ->subject('Confirmation de votre commande — Samy Dessert')
            ->html($this->twig->render('emails/confirmation_commande.html.twig', [
                'commande' => $commande,
            ]));

        $this->mailer->send($email);
    }
}
```

`$mailerFrom` est injecté depuis la variable d'environnement via `config/services.yaml` :

```yaml
App\Service\MailerService:
    arguments:
        $mailerFrom: '%env(MAILER_FROM)%'
```

Dans le controller, on appelle simplement :

```php
$this->mailerService->envoyerConfirmationCommande($commande);
```


---

# Vérification d'email à l'inscription

## Pourquoi vérifier l'email ?

Sans vérification, n'importe qui peut créer un compte avec une adresse email qui ne lui appartient pas. La vérification garantit que l'utilisateur contrôle bien l'adresse qu'il a saisie.

## Flux complet

```
1. Utilisateur remplit le formulaire d'inscription
2. Compte créé en base avec isVerified = false
3. Token aléatoire généré (64 caractères hex)
4. Email envoyé avec un lien : /confirmer-email/{token}
5. Utilisateur clique le lien
6. Symfony trouve le compte par le token
7. isVerified = true, token effacé
8. Email de bienvenue envoyé
9. Redirection vers /connexion
```

## Entité Utilisateur — champs ajoutés

```php
// Indique si l'utilisateur a confirmé son adresse email
#[ORM\Column]
private bool $isVerified = false;

// Token secret envoyé par email (null une fois vérifié)
#[ORM\Column(length: 64, nullable: true)]
private ?string $verificationToken = null;
```

## Génération du token

```php
// bin2hex(random_bytes(32)) = 64 caractères hexadécimaux aléatoires
$token = bin2hex(random_bytes(32));
// Exemple : "1f0d68d58bd71d4e5570dd87a1c055ee757c13150b65f51c3603532773e7a9b0"
```

`random_bytes(32)` génère 32 octets cryptographiquement sûrs. `bin2hex` les convertit en chaîne hexadécimale. Ce token est **impossible à deviner** (2²⁵⁶ combinaisons possibles).

## Génération de l'URL absolue

```php
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

$confirmationUrl = $this->generateUrl(
    'app_confirm_email',
    ['token' => $token],
    UrlGeneratorInterface::ABSOLUTE_URL, // http://localhost:8080/confirmer-email/abc123...
);
```

Sans `ABSOLUTE_URL`, `generateUrl` retourne un chemin relatif (`/confirmer-email/...`). Dans un email, le lien doit être absolu pour être cliquable depuis n'importe quel client email.

L'URL de base est configurée dans `.env.local` :
```
DEFAULT_URI=http://localhost:8080
```

## Route de confirmation

```php
#[Route('/confirmer-email/{token}', name: 'app_confirm_email')]
public function confirmerEmail(string $token, EntityManagerInterface $em): Response
{
    $user = $em->getRepository(Utilisateur::class)->findOneBy(['verificationToken' => $token]);

    if (!$user) {
        return $this->render('security/confirm_invalid.html.twig');
    }

    $user->setIsVerified(true);
    $user->setVerificationToken(null); // effacé = ne peut plus resservir
    $em->flush();

    $this->addFlash('success', 'Compte activé. Vous pouvez vous connecter.');
    return $this->redirectToRoute('app_login');
}
```

## UserChecker — bloquer la connexion si non vérifié

Symfony Security permet d'intercepter la connexion via un `UserChecker` :

```php
// src/Security/UserChecker.php
class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Utilisateur) return;

        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException(
                "Votre compte n'est pas encore activé. Vérifiez votre email."
            );
        }
    }

    public function checkPostAuth(UserInterface $user): void {}
}
```

`checkPreAuth` est appelé **avant** la vérification du mot de passe. Si on lève une exception ici, Symfony affiche le message à l'utilisateur sur la page de connexion.

Enregistrement dans `security.yaml` :

```yaml
firewalls:
    main:
        user_checker: App\Security\UserChecker
```

---

# Symfony Messenger — file de messages

## Définition

Symfony Messenger est un composant qui permet d'**envoyer des messages** (tâches) dans une file d'attente, traitée de façon asynchrone par un **worker**.

## Synchrone vs Asynchrone

| Mode | Comportement | Quand l'utiliser |
|------|-------------|-----------------|
| `sync` | Traité immédiatement pendant la requête HTTP | Développement |
| `async` | Mis en file, traité par un worker en arrière-plan | Production |

## Pourquoi async en production ?

Envoyer un email prend du temps (connexion SMTP). En mode async :
1. La requête HTTP se termine immédiatement (l'utilisateur n'attend pas)
2. L'email est stocké dans la table `messenger_messages`
3. Un worker PHP tourne en arrière-plan et envoie l'email

En mode sync, l'utilisateur attend que l'email soit envoyé avant de voir la réponse.

## Configuration (`config/packages/messenger.yaml`)

```yaml
routing:
    Symfony\Component\Mailer\Messenger\SendEmailMessage: sync   # dev
    # Symfony\Component\Mailer\Messenger\SendEmailMessage: async  # prod
```

## Lancer le worker (production)

```bash
docker compose exec php php bin/console messenger:consume async
```

---

# Fichiers .env — ordre de priorité

Symfony charge les fichiers `.env` dans cet ordre, chaque fichier **écrasant** le précédent :

| Fichier | Commité git | Rôle |
|---------|-------------|------|
| `.env` | ✅ Oui | Valeurs par défaut pour tout le monde. Jamais de secrets. |
| `.env.local` | ❌ Non | Tes overrides locaux (mots de passe, DSN). Ignoré par git. |
| `.env.dev` | ✅ Oui | Valeurs spécifiques à l'env `dev` uniquement. |
| `.env.dev.local` | ❌ Non | Overrides locaux pour `dev` uniquement. |
| `.env.prod` | ✅ Oui | Valeurs pour la production. |
| `.env.prod.local` | ❌ Non | Overrides locaux pour la production. |

**Règle :** tout ce qui est secret ou spécifique à ta machine → `.env.local`. Le `.env` ne contient que des exemples ou des valeurs neutres.

**Attention Docker :** les variables définies dans `docker-compose.yml` sous `environment:` écrasent les fichiers `.env` et `.env.local`. Elles ont la priorité la plus haute.

---

# Erreur 502 Bad Gateway

## Définition

Une **502 Bad Gateway** signifie que le serveur intermédiaire (ici nginx) n'a pas pu joindre le serveur en amont (ici PHP-FPM).

```
Navigateur → nginx (port 8080) → PHP-FPM (port 9000)
                                      ↑
                               Si PHP ne répond pas → 502
```

## Cause fréquente en Docker

Nginx résout le hostname `php` en IP **une seule fois au démarrage**. Si le conteneur PHP redémarre, il obtient une nouvelle IP, mais nginx garde l'ancienne en cache → 502.

## Fix permanent dans `docker/nginx/default.conf`

```nginx
# Force nginx à re-résoudre le DNS Docker toutes les 30s
resolver 127.0.0.11 valid=30s ipv6=off;

location ~ ^/index\.php(/|$) {
    set $php_backend php:9000;  # variable = force la re-résolution
    fastcgi_pass $php_backend;
}
```

`127.0.0.11` est le serveur DNS interne de Docker. Utiliser une **variable** pour `fastcgi_pass` force nginx à passer par le resolver à chaque requête au lieu de mettre l'IP en cache.

## Fix immédiat

```bash
docker compose restart nginx
```

---

# Panier (session)

## Principe

Le panier est stocké en **session PHP** — pas en base de données. C'est la méthode classique pour un panier e-commerce simple :

```
Session : $_SESSION['panier'] = [
    42 => 2,   // produit id=42 → quantité 2
    17 => 1,   // produit id=17 → quantité 1
]
```

Avantages : pas de SQL, fonctionne sans connexion, disparaît à la fermeture de session.

## Service `PanierService`

Toute la logique du panier est dans un seul service injecté partout où on en a besoin :

```php
class PanierService
{
    public function ajouter(int $produitId): void { ... }
    public function retirer(int $produitId): void { ... }   // retire 1
    public function supprimer(int $produitId): void { ... } // supprime la ligne
    public function vider(): void { ... }
    public function getLignes(): array { ... }  // [['produit' => Produit, 'quantite' => int]]
    public function getTotal(): float { ... }
    public function getQuantitePourProduit(int $id): int { ... } // lecture session, 0 SQL
}
```

`getQuantitePourProduit()` lit uniquement la session (pas de SQL) — utile pour les composants qui s'affichent en masse sur une page produits.

## Controller `PanierController`

```php
#[Route('/panier', name: 'app_panier_')]
class PanierController
{
    #[Route('', name: 'index')]                              // GET  → affiche le panier
    #[Route('/ajouter/{id}',  name: 'ajouter',  methods: ['POST'])]
    #[Route('/retirer/{id}',  name: 'retirer',  methods: ['POST'])]
    #[Route('/supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    #[Route('/vider',         name: 'vider',    methods: ['POST'])]
}
```

> **Pourquoi POST ?** Toutes les modifications d'état doivent utiliser POST, pas GET. Avec GET, un simple lien ou un robot peut déclencher l'action par erreur.

---

# Symfony UX Live Components

## AJAX — qu'est-ce que c'est ?

**AJAX** = **A**synchronous **J**avaScript **A**nd **X**ML.

Technique qui permet au navigateur de faire une requête HTTP vers le serveur **en arrière-plan**, sans recharger la page entière.

**Sans AJAX :**
```
clic → rechargement complet de la page → nouvelle réponse HTML
```

**Avec AJAX :**
```
clic → requête en fond → serveur répond → JS met à jour juste la partie concernée
```

Dans le contexte des Live Components, quand tu cliques "Ajouter au panier" :
1. Symfony UX envoie une requête AJAX au serveur
2. Le serveur re-rend uniquement le composant `BoutonPanier`
3. Le HTML retourné remplace l'ancien HTML du composant dans la page
4. La page ne se recharge pas

> Le "XML" dans le nom est historique — aujourd'hui on échange du HTML ou du JSON, plus du XML.

## Composant statique vs live

| | Statique `#[AsTwigComponent]` | Live `#[AsLiveComponent]` |
|---|---|---|
| Rendu | Une seule fois côté serveur | Re-rendu via AJAX à chaque action |
| Actions | Aucune | `#[LiveAction]` déclenchées par Stimulus |
| Props | `public $prop` | `#[LiveProp]` (synchronisées client/serveur) |
| Rechargement page | Oui (formulaire POST) | Non |
| Usage typique | Affichage, mise en page | Compteur panier, formulaires dynamiques |

## Structure d'un live component

### PHP

```php
#[AsLiveComponent]
final class BoutonPanier
{
    use DefaultActionTrait;  // obligatoire

    #[LiveProp]
    public int $produitId = 0;   // prop synchronisée avec le client

    #[LiveProp]
    public int $quantite = 0;

    // Services injectés par le constructeur (pas dans les actions)
    public function __construct(private PanierService $panier) {}

    // mount() = appelé uniquement au premier rendu (pas sur les re-rendus AJAX)
    public function mount(): void
    {
        $this->quantite = $this->panier->getQuantitePourProduit($this->produitId);
    }

    // LiveAction = méthode déclenchée depuis le template via AJAX
    #[LiveAction]
    public function ajouter(): void
    {
        $this->panier->ajouter($this->produitId);
        $this->quantite = $this->panier->getQuantitePourProduit($this->produitId);
    }
}
```

### Template Twig

```twig
{# OBLIGATOIRE : un seul élément racine fixe (toujours présent) #}
<div {{ attributes }}>
  {% if quantite == 0 %}
    <button
      data-action="live#action"
      data-live-action-param="ajouter"
    >
      Ajouter au panier
    </button>
  {% else %}
    <span>{{ quantite }}</span>
  {% endif %}
</div>
```

### Appel depuis un autre template

```twig
<twig:BoutonPanier :produitId="produit.id" :produitNom="produit.nom" />
```

## Règles importantes

- **Un seul élément racine** dans le template — le live component met à jour cet élément en AJAX (morphing). S'il y a deux éléments racines possibles, le morphing échoue silencieusement.
- **`mount()` ≠ constructeur** — `mount()` initialise le composant avec les props du template. Appelé uniquement au premier rendu.
- **`#[LiveProp]`** — la valeur est sérialisée dans le HTML et renvoyée au serveur à chaque requête AJAX.
- **Services** → injecter dans le constructeur, jamais dans les `#[LiveAction]`.

## Référence des attributs et traits Live Component

### `DefaultActionTrait`
Trait **obligatoire** sur tout Live Component. Il fournit l'action `__invoke` par défaut que le système AJAX utilise en interne pour déclencher un re-rendu.

```php
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class MonComposant
{
    use DefaultActionTrait; // toujours présent
}
```

---

### `#[LiveProp]`
Déclare une propriété **synchronisée entre le serveur et le client**. Sa valeur est sérialisée dans le HTML généré, puis renvoyée au serveur à chaque requête AJAX.

```php
#[LiveProp]
public int $produitId = 0;

// writable: true → le client peut modifier la valeur (ex: champ texte lié)
#[LiveProp(writable: true)]
public string $recherche = '';
```

| Option | Effet |
|---|---|
| `writable: true` | La valeur peut être modifiée depuis le front (input lié) |
| `writable: false` (défaut) | Lecture seule — le serveur contrôle la valeur |

> **Attention** : ne jamais mettre de données sensibles dans un `#[LiveProp]` — elles sont visibles dans le HTML.

---

### `#[LiveAction]`
Déclare une méthode PHP déclenchable depuis le template via AJAX, sans rechargement de page.

```php
#[LiveAction]
public function ajouter(): void
{
    $this->panier->ajouter($this->produitId);
    // pas de return — le composant se re-rend automatiquement
}
```

Dans le template :
```twig
<button
  data-action="live#action"
  data-live-action-param="ajouter"
>
  Ajouter
</button>
```

---

### `#[LiveListener]`
Permet au composant d'écouter un **événement émis par un autre composant**. Quand l'événement est reçu, la méthode annotée est appelée et le composant se re-rend.

```php
#[LiveListener('panierUpdated')]
public function onPanierUpdated(): void
{
    // rien à faire ici : le re-rendu suffit
    // (getNombreArticles() sera rappelé automatiquement)
}
```

---

### `emit()` — émettre un événement
Pour qu'un composant notifie les autres, on utilise `$this->emit()` depuis une `#[LiveAction]`.

```php
use Symfony\UX\LiveComponent\ComponentToolsTrait;

#[AsLiveComponent]
final class BoutonPanier
{
    use DefaultActionTrait;
    use ComponentToolsTrait; // nécessaire pour emit()

    #[LiveAction]
    public function ajouter(): void
    {
        $this->panier->ajouter($this->produitId);
        $this->emit('panierUpdated'); // PanierBadge l'écoute et se met à jour
    }
}
```

---

### Résumé visuel

```
BoutonPanier                      PanierBadge
─────────────────                 ───────────────────
#[LiveAction] ajouter()           #[LiveListener('panierUpdated')]
  → panier->ajouter()               → se re-rend (compteur mis à jour)
  → emit('panierUpdated') ──────────►
```

## Passer des arguments à une action (`#[LiveArg]`)

```php
#[LiveAction]
public function supprimer(#[LiveArg] int $id): void { ... }
```

```twig
<button
  data-action="live#action"
  data-live-action-param="supprimer"
  data-live-id-param="{{ produit.id }}"
>
```

## Installation

```bash
composer require symfony/ux-live-component
php bin/console importmap:require @symfony/ux-live-component
```

Enregistrer dans `assets/stimulus_bootstrap.js` :

```js
// Import par défaut (PAS import { LiveController })
import LiveController from '@symfony/ux-live-component';
const app = Application.start();
app.register('live', LiveController);
```

> **Piège fréquent** : `import { LiveController }` est incorrect. Le package exporte le controller en `default`, pas en export nommé.

## Déboguer un live component

- **F12 → Console** : erreurs JS
- **F12 → Network** : cherche les requêtes POST vers `/_components/...` — si elles partent, le JS fonctionne ; si elles retournent une erreur, c'est côté PHP
- `php bin/console cache:clear` après toute modification PHP

---

# OPcache PHP

## Définition

**OPcache** est une extension PHP qui met en cache le **bytecode compilé** des fichiers PHP. Sans OPcache, PHP relit, parse et recompile chaque fichier à chaque requête.

```
Sans OPcache :  requête → lire fichier → parser → compiler → exécuter
Avec OPcache :  requête → (bytecode déjà en mémoire) → exécuter
```

Symfony charge des centaines de fichiers PHP par requête. Sans OPcache : 500ms–2s. Avec OPcache : 100–300ms.

## Activer dans le Dockerfile

```dockerfile
RUN docker-php-ext-install opcache

RUN echo "opcache.enable=1\nopcache.memory_consumption=256\nopcache.max_accelerated_files=20000\nopcache.revalidate_freq=0\nopcache.validate_timestamps=1" \
    > /usr/local/etc/php/conf.d/opcache.ini
```

`validate_timestamps=1` + `revalidate_freq=0` = vérifie les modifications à chaque requête (dev). En production : `revalidate_freq=60`.

Après modification du Dockerfile, rebuild obligatoire :

```bash
docker-compose down
docker-compose build php
docker-compose up -d
```

---

# Bundles vs code manuel

## Principe

Un **bundle** Symfony est un package qui encapsule une fonctionnalité complète. On peut souvent remplacer un bundle par du code manuel pour mieux comprendre les mécanismes.

## Comparatif

| Bundle | Ce qu'il fait | Code manuel équivalent |
|--------|--------------|----------------------|
| `symfonycasts/verify-email-bundle` | URLs signées HMAC pour vérification email | Token `bin2hex(random_bytes(32))` en base |
| `symfony/mailer` | Abstraction SMTP + intégration Twig | `PHPMailer` directement |
| `symfony/form` | FormBuilder, validation, CSRF | HTML pur + validation `if` |
| `symfony/validator` | `#[Assert\NotBlank]` etc. | Conditions `if` dans le controller |
| `symfony/security-bundle` | Firewall, hash password | Sessions PHP + `password_hash()` |
| `doctrine/orm` | Mapping PHP ↔ SQL | PDO pur avec requêtes SQL |

## `symfonycasts/verify-email-bundle` — ce qui serait remplacé

| Notre code manuel | Ce que le bundle fait |
|---|---|
| `bin2hex(random_bytes(32))` | URL signée HMAC |
| Champ `verificationToken` en base | Aucun stockage DB (token dans la signature) |
| `findOneBy(['verificationToken' => $token])` | `$helper->validateEmailConfirmationFromRequest()` |
| Pas d'expiration | Expiration configurable (1h par défaut) |

Ce qui resterait identique : `UserChecker`, `MailerService`, templates email.

---

# Performances Symfony en dev

## Pourquoi c'est lent

- **OPcache désactivé** : PHP recompile chaque fichier à chaque requête
- **Mode debug** : profiler, vérification des fichiers modifiés, cache container recompilé
- **Container `assets`** : rebuild Tailwind en boucle (toutes les 3s)

## Optimisations

1. Activer OPcache dans le Dockerfile
2. Éteindre le container `assets` quand pas nécessaire
3. Désactiver la toolbar dans `config/packages/web_profiler.yaml` :
   ```yaml
   web_profiler:
       toolbar: false
   ```

## Commandes cache

```bash
# Vider le cache (depuis Docker, pas Windows — fichiers verrouillés)
docker-compose exec php php bin/console cache:clear

# Relancer init (vide cache + migrations)
docker-compose restart init
```

> **Important** : Ne jamais supprimer `var/cache/` depuis Windows. Toujours passer par `docker-compose exec php`.

---

# Organisation des fichiers CSS

## Règle générale avec Tailwind v4

`app.css` est le **point d'entrée unique** — il contient `@import "tailwindcss"`, `@source`, `@theme`, `@font-face`, et toutes les classes custom. Pas besoin de le découper en fichiers séparés.

## Pourquoi email.css et pdf.css existent quand même

Ces deux fichiers existent pour des **contextes d'exécution isolés** où le pipeline Tailwind ne tourne pas :

| Fichier | Contexte | Raison |
|---------|----------|--------|
| `email.css` | Clients email (Gmail, Outlook…) | Ne supportent pas les variables CSS (`var(--color-*)`) ni Tailwind — valeurs hex directes obligatoires |
| `pdf.css` | Moteur PDF (Dompdf/Wkhtmltopdf) | Ne charge pas le pipeline Tailwind — même besoin |

Ces fichiers sont chargés directement dans leurs templates respectifs, pas via l'asset mapper.

## Pourquoi PAS un carousel.css

Le carousel est rendu dans des templates Twig normaux via le même `app.css`. Un fichier séparé devrait être importé dans `app.css` de toute façon — autant garder une section commentée dans le même fichier.

## Ce que Tailwind v4 fournit automatiquement

`@import "tailwindcss"` inclut **Preflight** — un reset CSS complet qui normalise `html`, `body`, marges, box-sizing, etc. Pas besoin d'ajouter de CSS de base pour `html` et `body`.

---

# Tokens de couleur — conventions

Dans `app.css`, les couleurs sont définies via `@theme` avec la convention `--color-[nom]`. Tailwind génère automatiquement les classes `bg-*`, `text-*`, `border-*` correspondantes.

| Token | Classe Tailwind | Usage |
|-------|----------------|-------|
| `--color-surface` | `bg-surface` | Fonds de cartes, dropdowns, sidebar |
| `--color-border` | `border-border` | Toutes les bordures |
| `--color-danger` | `text-danger` | Erreurs, déconnexion, annulations |
| `--color-danger-light` | `bg-danger-light` | Hover sur actions dangereuses |

---

# Stimulus

## C'est quoi ?

Stimulus est un framework JavaScript **léger** créé par les auteurs de Ruby on Rails. Au lieu d'écrire du JS libre dans des `<script>`, on organise le code en **controllers** — des classes JS attachées à des éléments HTML via des attributs `data-*`.

**Philosophie :** le HTML reste dans Twig, le JS ne gère que le comportement.

## Les 3 concepts clés

| Concept | Attribut HTML | Accès en JS |
|---|---|---|
| **Controller** | `data-controller="nav-toggle"` | Classe JS activée sur cet élément |
| **Target** | `data-nav-toggle-target="menu"` | `this.menuTarget` |
| **Action** | `data-action="nav-toggle#toggle"` | Appelle `toggle()` au clic |

## Exemple concret — nav-toggle

```html
<header data-controller="nav-toggle">
  <button data-action="nav-toggle#toggle">Menu</button>
  <dialog data-nav-toggle-target="menu">...</dialog>
</header>
```

```js
export default class extends Controller {
  static targets = ['menu']

  toggle() {
    this.menuTarget.show() // Stimulus trouve l'élément automatiquement
  }
}
```

## Enregistrement dans le projet

Chaque controller doit être déclaré dans `assets/stimulus_bootstrap.js` :

```js
import NavToggleController from './controllers/nav_toggle_controller.js'
app.register('nav-toggle', NavToggleController)
```

Puis compilé avec :
```bash
php bin/console asset-map:compile
```

---

# Stripe Webhook

## C'est quoi un webhook ?

Un webhook est une URL sur ton serveur que Stripe appelle automatiquement quand un événement se produit (paiement réussi, remboursement, etc.).

## Sans webhook (situation actuelle)

```
Utilisateur paie → Stripe redirige vers /commande/succes → commande créée
```

**Problème :** si la redirection échoue (internet coupé, onglet fermé), la commande n'est jamais créée. Ou à l'inverse, quelqu'un navigue manuellement vers `/commande/succes` sans avoir payé.

## Avec webhook

```
Utilisateur paie → Stripe appelle ton serveur en arrière-plan → commande créée
                   (indépendant du navigateur de l'utilisateur)
```

Stripe envoie un `POST` à `/stripe/webhook` avec les infos du paiement. Le serveur vérifie la **signature** (pour s'assurer que c'est bien Stripe qui envoie), puis crée la commande.

**Obligatoire en production.** En développement local avec les clés test, l'implémentation actuelle (redirection) fonctionne.

---

# UX — Placeholders

## Règle d'utilisation

Les placeholders **disparaissent** dès que l'utilisateur commence à taper. Ils ne remplacent pas un `<label>`.

| Cas | Recommandation |
|---|---|
| Champ avec label | Le placeholder est inutile s'il répète le label |
| Format spécifique | Utile pour montrer l'exemple (`jean@exemple.fr`, `06 12 34 56 78`, `75001`) |
| Contrainte | Préférer `help` (reste visible pendant la saisie) |

**Dans ce projet :** placeholders uniquement sur email, téléphone et code postal pour montrer le format attendu.

---

# CSS — Cascade et `@layer`

## Pourquoi `hidden` ne fonctionnait pas avec Font Awesome

Tailwind v4 place ses utilitaires dans `@layer utilities`. En CSS Cascade Level 5, les règles dans un `@layer` ont **toujours moins de priorité** que les règles sans layer (dites "unlayered").

Font Awesome définit `display: inline-block` en CSS unlayered → il gagne sur `hidden` de Tailwind (`@layer utilities`), peu importe l'ordre de chargement.

**Solution :** utiliser des `inline styles` en JS (`element.style.display = 'none'`). Les styles inline ont la priorité absolue sur tout CSS.

## Tailwind v4 — pièges à connaître

### Valeurs négatives arbitraires

```
❌ -right-[3px]     (syntaxe Tailwind v3)
✅ right-[-3px]     (syntaxe Tailwind v4 — le - est à l'intérieur)
```

### Combiner translate-x et translate-y

En Tailwind v4, `translate-x-*` et `translate-y-*` déclarent tous les deux la propriété CSS `translate`. Le dernier dans la cascade écrase le premier.

```
❌ class="translate-x-1/2 -translate-y-1/2"   (conflit — un seul s'applique)
✅ class="[translate:50%_-50%]"               (une seule déclaration, les deux axes)
```

### Pourquoi `translate: 50%` centre un badge sur un coin

```
top-0 right-0             → coin haut-droit du badge = coin haut-droit du parent
[translate:50%_-50%]      → décale de 50% de la taille DU BADGE lui-même
                             → centre du badge = coin du parent ✓
```

Les `%` dans `translate` sont relatifs à **l'élément lui-même**, pas au parent.

**Règle** : ne jamais utiliser `bg-white`, `text-red-600`, `border-gray-200` etc. — toujours passer par les tokens du projet.

PHP
1. Rôle du contrôleur

Un contrôleur sert à :

recevoir une requête (URL)
exécuter du code
renvoyer une réponse (souvent une vue)

👉 Exemple :

URL /mentions-legales
→ appelle une méthode
→ affiche un template Twig
2. Structure du fichier
namespace App\Controller;
organise le code
correspond au dossier src/Controller
évite les conflits de noms
use ...
importe des classes Symfony
permet d’utiliser :
AbstractController
Response
Route
3. AbstractController

👉 Classe de base de Symfony

Elle te donne des outils :

render() → afficher une vue
redirectToRoute() → redirection
getUser() → utilisateur connecté

⚠️ On ne l’utilise pas directement :

parce qu’elle est abstraite
donc on fait extends
4. La route
Une route est la règle qui associe une URL à une méthode PHP (dans un controller).
Quand le navigateur visite une URL, Symfony parcourt toutes les routes définies et appelle la méthode correspondante.

#[Route(‘/mentions-legales’, name: ‘app_mentions_legales’)]
définit l’URL
relie l’URL à une méthode
donne un nom interne (utilisé dans Twig avec path(‘app_mentions_legales’))

💡 methods: [‘GET’] — obligatoire ou pas ?
C’est un choix, pas une obligation. Sans methods: [‘GET’], Symfony accepte tous les verbes HTTP (GET, POST, PUT...) sur cette route.
Pour une route d’affichage simple, ne pas le mettre est parfaitement correct.
Pour les actions (formulaires, suppressions...), on précise toujours methods: [‘POST’] pour être explicite.
La sécurité ne vient pas du verbe HTTP autorisé, mais du code dans le controller (CSRF, IsGranted, validation des données).
5. La méthode
public function index(): Response
fonction exécutée quand on visite l’URL
renvoie une Response
6. Le rendu
return $this->render('mentions_legales/index.html.twig');
affiche un fichier Twig
situé dans templates/
renvoie du HTML au navigateur
🔗 Chaîne complète (très important)

👉 Navigateur → URL
→ Route
→ Contrôleur
→ Méthode
→ Template Twig
→ Réponse HTML

---

## Typage et type hints en PHP

### C'est quoi ?
Le typage consiste à dire au code quel type de donnée une variable, un paramètre ou une fonction doit contenir ou retourner.
PHP est un langage faiblement typé à la base — sans type hints, il accepte n'importe quoi sans se plaindre.

### Type hint sur un paramètre
```php
public function index(Request $request): Response
```
`Request $request` → le paramètre $request doit être une instance de la classe Request.
Si tu passes autre chose, PHP lève une erreur immédiatement.

### Type hint sur le retour
```php
public function index(): Response
```
`: Response` → la méthode doit retourner une instance de Response.
C'est ce qu'on appelle le **return type**.

### Les types disponibles
```php
string       // chaîne de caractères
int          // entier
float        // décimal
bool         // true / false
array        // tableau
null         // null
?string      // string OU null (le ? rend le type nullable)
void         // la fonction ne retourne rien
mixed        // n'importe quoi (à éviter)
NomDeClasse  // une instance d'une classe précise
```

### Exemple concret (dans le projet)
```php
public function show(string $slug, ProduitRepository $produitRepo): Response
```
- `string $slug` → on attend une chaîne (le slug dans l'URL)
- `ProduitRepository $produitRepo` → Symfony injecte automatiquement ce service (injection de dépendances)
- `: Response` → la méthode retourne toujours une Response Symfony

### Pourquoi c'est utile ?
- Détecte les erreurs tôt (avant l'exécution) plutôt qu'en prod
- Aide l'IDE à faire de l'autocomplétion
- Rend le code plus lisible : on sait exactement ce qu'attend et ce que retourne une fonction
- Symfony l'utilise pour l'injection de dépendances automatique (il lit les types des paramètres pour savoir quoi injecter)

### Type hint vs assert()
```php
// Type hint → vérifié par PHP au moment de l'appel
public function doSomething(string $nom): void {}

// assert() → vérifié manuellement au moment de l'exécution
$user = $this->getUser();
assert($user instanceof Utilisateur); // narrowing pour l'IDE, pas une contrainte PHP
```
`assert()` sert à dire à l'IDE "fais confiance, c'est bien ce type ici" — ça ne remplace pas un vrai type hint.

---

## Lecture d'un controller Symfony — MentionsLegalesController

### Le fichier complet
```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MentionsLegalesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        return $this->render('mentions_legales/index.html.twig');
    }
}
```

### Ligne par ligne

**`<?php`**
Obligatoire au début de tout fichier PHP. Dit au serveur que ce qui suit est du PHP.

**`namespace App\Controller;`**
Déclare l'emplacement de ce fichier dans le projet. Correspond au dossier `src/Controller/`.
Symfony utilise le namespace pour retrouver la classe automatiquement (autoloading).

**Les `use`**
Importent des classes externes pour pouvoir les utiliser par leur nom court.
Sans `use`, il faudrait écrire le chemin complet à chaque fois :
```php
// sans use
public function index(): \Symfony\Component\HttpFoundation\Response

// avec use
use Symfony\Component\HttpFoundation\Response;
public function index(): Response
```
- `AbstractController` → classe de base Symfony qui donne accès à render(), redirectToRoute(), addFlash()...
- `Response` → l'objet retourné au navigateur
- `Route` → l'attribut PHP qui définit l'URL

**`class MentionsLegalesController extends AbstractController`**
On déclare une classe qui hérite d'AbstractController.
`extends` = on récupère toutes les méthodes de la classe parente.
Sans `extends AbstractController`, `$this->render()` n'existerait pas.

**`#[Route('/mentions-legales', name: 'app_mentions_legales')]`**
Attribut PHP (les `#[...]`). Dit à Symfony :
- quelle URL déclenche cette méthode → `/mentions-legales`
- le nom interne de la route → utilisé dans Twig avec `path('app_mentions_legales')`

**`public function index(): Response`**
- `public` → accessible depuis l'extérieur de la classe
- `index` → nom de la méthode (arbitraire)
- `: Response` → type hint de retour (optionnel mais recommandé)

💡 Le `: Response` est optionnel — PHP exécute le code sans lui.
Il sert à documenter l'intention et à détecter les bugs tôt.
Si tu retournes autre chose qu'une Response par erreur, PHP lève une erreur immédiatement.

**`return $this->render('mentions_legales/index.html.twig');`**
- `$this->render()` → méthode héritée d'AbstractController
- Lit le fichier Twig dans `templates/`, génère le HTML, l'emballe dans un objet Response
- C'est cet objet Response que Symfony envoie au navigateur

### Comment savoir ce que retourne une méthode ?
Trois façons :
1. **L'IDE** → passer la souris sur la méthode affiche sa signature
2. **La doc Symfony** → symfony.com documente chaque méthode
3. **Le code source** → `vendor/symfony/framework-bundle/Controller/AbstractController.php`

### Flux complet
```
Navigateur visite /mentions-legales
→ Symfony lit les routes → trouve #[Route('/mentions-legales')]
→ Appelle MentionsLegalesController::index()
→ render() lit le fichier Twig → génère le HTML
→ Retourne une Response avec le HTML
→ Navigateur affiche la page
```

---

## Turbo Frames (Hotwire)

Symfony UX intègre `@hotwired/turbo`. Les **Turbo Frames** permettent de ne rafraîchir qu'une partie de la page sans recharger toute la vue.

### Principe

```html
<!-- Dans le template -->
<turbo-frame id="produits-results">
  <!-- Seul ce bloc est remplacé lors d'une navigation ciblée -->
</turbo-frame>
```

Un lien ou formulaire peut cibler ce frame :
```html
<a href="/produits?categorie=tartes" data-turbo-frame="produits-results">Tartes</a>
<form data-turbo-frame="produits-results">...</form>
```

### Turbo Drive vs Turbo Frames

| | Turbo Drive | Turbo Frames |
|---|---|---|
| Périmètre | Toute la page (`<body>`) | Un élément `<turbo-frame>` |
| Activation | Automatique sur tous les liens | Explicite avec `data-turbo-frame` |
| Conflit Live Components | Oui (`Content missing`) | Non |

**Dans ce projet** : Turbo Drive est désactivé (`Turbo.session.drive = false`) pour éviter les conflits avec Symfony UX Live Components. Seuls les Turbo Frames sont utilisés.

### Où c'est utilisé

- `/produits` et `/recettes` : sidebar catégories + grille se met à jour sans recharger hero/searchbar
- `/produits/{slug}` : section avis se met à jour après soumission sans recharger la page produit

---

## `data-loading` (Symfony UX Live Component)

Les éléments avec `data-loading="show"` s'affichent pendant le chargement d'un Live Component.
Les éléments avec `data-loading="hide"` se masquent pendant le chargement.

⚠️ `data-loading="show"` applique `display: block`, pas `display: flex`. Éviter `items-center` sur cet élément — centrer avec `absolute inset-0 m-auto` à la place.

```html
<twig:Atoms:Icon name="cart-plus" data-loading="hide" />
<twig:Atoms:Spinner class="hidden" data-loading="show" />
```

---

## Dialog native HTML (`<dialog>`)

L'élément `<dialog>` est natif HTML5. Avec `showModal()` il s'affiche en top layer avec backdrop.

```js
dialog.showModal() // ouvre en modal (focus trap + Échap = ferme)
dialog.close()     // ferme
```

```css
dialog::backdrop { background: rgba(0,0,0,0.5); }
/* En Tailwind : backdrop:bg-overlay */
```

**Centrage** : Tailwind v4 peut réinitialiser `margin: auto` — ajouter `m-auto` sur le `<dialog>`.

**Accessibilité** : `showModal()` gère automatiquement le focus trap et la touche Échap.

---

## Conflits de classes Tailwind

Quand deux classes du même groupe CSS (`rounded-md` et `rounded-full`) sont toutes deux dans le HTML, c'est l'ordre dans le **fichier CSS généré** qui détermine laquelle s'applique — pas l'ordre dans l'attribut `class`.

**Solution** : ne pas avoir de conflits. Si tous les boutons ont `rounded-full`, le mettre dans la classe de base, pas dans chaque variant.

Sans `tailwind-merge`, il faut concevoir les composants pour éviter les classes conflictuelles.

---

## JS dynamique vs Twig + Tailwind

### Pourquoi le carousel ne utilise pas Twig ni Tailwind

Le fichier `carousel_controller.js` crée des éléments HTML directement en JS (`document.createElement`). C'est normal et correct.

**Règle générale :**
- HTML de page / composants → **Twig + Tailwind**
- DOM créé dynamiquement par JS → **classes CSS custom dans `app.css`**

**Pourquoi Twig est impossible ici :**
Twig est un moteur de template qui s'exécute **côté serveur** (PHP). Le controller JS s'exécute **côté navigateur**. Au moment où le JS tourne, Twig a déjà fini son travail — il n'est plus accessible.

**Pourquoi les classes custom plutôt que Tailwind :**
Pour un widget JS comme un carousel, les classes structurelles (`carousel__prev`, `carousel__item--zoom`) décrivent l'état interne du composant. Les utiliser directement dans `app.css` avec `@apply` ou des règles CSS classiques est plus lisible et maintenable que d'injecter des classes Tailwind via JS.

Note : Tailwind **peut** détecter des classes dans les fichiers JS (il scanne `assets/**/*.js`), donc si tu mets `class="flex items-center"` dans ton JS elles seront bien compilées. Mais pour les éléments structurels d'un widget, les classes BEM custom sont préférables.
