# Cours & Définitions — samyDessert

> Mis à jour au fil du projet. Chaque concept est expliqué dans le contexte de la stack utilisée.

---

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

## PHP

### Attribut PHP `#[...]`

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

### Entité Doctrine

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

## Symfony — Architecture

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

## Font Awesome 7

La syntaxe a changé par rapport à FA5/FA6 :

| Version | Syntaxe valide |
|---|---|
| FA5 / FA6 | `<i class="fas fa-star"></i>` |
| FA7 | `<i class="fa-solid fa-star"></i>` ou `<i class="fas fa-star"></i>` |

Les icônes prennent la couleur du texte parent (`currentColor`). Pour coloriser avec Tailwind : `<i class="fa-solid fa-star text-star"></i>`

---

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

## Doctrine ORM — Concepts avancés

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

## Architecture des fichiers (résumé)

```
samyDessert/
├── assets/
│   ├── app.js                    # point d'entrée JS + Stimulus
│   ├── styles/app.css            # Tailwind + @theme
│   └── vendor/                   # dépendances téléchargées
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
