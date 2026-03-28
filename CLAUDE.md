# samyDessert — Conventions de développement

## Début de conversation
- **Toujours relire ta mémoire** (`MEMORY.md` + fichiers liés) avant de commencer à travailler
- **Consulter l'état du projet** dans `project_state.md` pour connaître l'avancement, les prochaines étapes et le contexte
- Si une conversation précédente existe, prendre en compte le résumé pour assurer la continuité

## Stack
- Symfony + Twig + Tailwind CSS (JIT) + Stimulus + Symfony UX Twig Components
- Lancer en dev : `symfony serve` + `php bin/console tailwind:build --watch`

## Architecture des composants (Atomic Design)
- `templates/components/atoms/` + `src/Twig/Components/Atoms/`
- `templates/components/molecules/` + `src/Twig/Components/Molecules/`
- `templates/components/organisms/` + `src/Twig/Components/Organisms/`

## Règles Twig Components

### `this.` uniquement pour les getters PHP
```twig
{{ rows }}           {# prop publique → accès direct #}
{{ this.computedId }} {# getter PHP → this. obligatoire #}
```

### `this.` change de contexte dans les sous-composants
À l'intérieur d'un bloc `<twig:Atoms:Link>`, `this` = Link, pas le parent.
Toujours extraire en `{% set %}` avant d'entrer dans un sous-composant :
```twig
{% set logoAlt = logoAlt ?: brandLabel %}
<twig:Atoms:Link ...>
  <img alt="{{ logoAlt }}">
</twig:Atoms:Link>
```

### `attributes.defaults()` sur l'élément racine
Permet la surcharge de class depuis l'appelant :
```twig
{{ attributes.defaults({ class: 'mes-classes-par-défaut' }) }}
```

### Props vs Attributes
- Props déclarées en PHP → variables Twig directes
- Tout le reste (id, name, placeholder, data-*, aria-*) → passe par `attributes`
- Ne pas redéclarer en PHP ce qui peut passer par attributes

## Règles PHP

### Toujours mettre des valeurs par défaut
```php
public string $label = '';  // ✅
public string $label;       // ❌ erreur PHP si non passé
```

### Getters pour les valeurs calculées
```php
// ✅ getter calculé depuis $items
public function getTotalPrice(): float {
    return array_sum(array_map(fn($i) => $i['quantity'] * $i['price'], $this->items));
}
// ❌ prop stockée qui peut se désynchroniser
public float $totalPrice = 0.0;
```

## Tailwind v4

- Pas de `tailwind.config.js` — tout dans `assets/styles/app.css`
- Scanner les templates : `@source "../../templates/**/*.twig";`
- Après chaque modif CSS : `php bin/console tailwind:build`

## Stimulus + Laragon

- `stimulus_bootstrap.js` démarre Stimulus avec `Application.start()` (pas `startStimulusApp()`)
- Enregistrement manuel des controllers dans `stimulus_bootstrap.js`
- **Après chaque modif JS** : `php bin/console asset-map:compile`

## TODO

### Développement
- [x] Pages à créer : `/produits`, `/recettes`, `/contact`, `/panier`, `/connexion`
- [x] Entités Doctrine : Produit, Commande, Utilisateur
- [x] Authentification Symfony Security
- [x] Composant `ProductCard` branché sur de vraies données
- [x] Composant `CartSummary` branché sur la session/panier (live component `PanierLive`)
- [x] Formulaire de contact fonctionnel
- [ ] Afficher/masquer le mot de passe sur les formulaires connexion/inscription
- [ ] Emails transactionnels (confirmation commande)
- [ ] Déplacer `docker/` et `docker-compose.yml` en dehors du dossier projet

### Optionnel
- [ ] Système d'avis (entité `Avis` : note + commentaire, relation User↔Produit, formulaire, note moyenne sur DessertCard)

### Documentation & Soutenance
- [ ] Ajouter des commentaires dans le code (PHP + Twig + JS)
- [ ] Rédiger un résumé du projet (stack, architecture, choix techniques)
- [ ] Générer un questionnaire d'entraînement pour l'évaluation de fin de projet

## Checklist — relire un template avant de valider

### Syntaxe
```bash
php bin/console lint:twig templates/
```

### Couleurs & tokens
- [ ] Pas de `bg-white` → `bg-surface` ou `bg-bg`
- [ ] Pas de `text-red-*` / `bg-red-*` → `text-danger` / `bg-danger-light`
- [ ] Pas de couleurs Tailwind brutes (`gray-*`, `amber-*`, `rose-*`…) → toujours un token du projet
- [ ] `border-surface` = **faux** → `border-border`

### Classes CSS
- [ ] Toute classe custom utilisée existe bien dans `app.css` (ex: `btn-cta-sm`, `page-title`…)
- [ ] Pas de style inline (`style="..."`) sauf cas impossible à faire autrement
- [ ] Éviter les valeurs arbitraires (`w-[1.5rem]`, `mt-[12px]`…) quand une classe Tailwind standard ou un token du projet suffit

### Composants Twig
- [ ] `decorative="true"` (string) → `:decorative="true"` (booléen)
- [ ] `this.prop` sur une prop simple → utiliser `prop` directement
- [ ] `this.getter` dans un sous-composant → extraire en `{% set %}` avant d'entrer
- [ ] Élément racine du composant a `{{ attributes.defaults({ class: '...' }) }}` pour permettre la surcharge

### Atomic Design
- [ ] Un bouton = `<twig:Atoms:Button>` ou `<twig:Atoms:Link>`, jamais un `<button>` ou `<a>` nu dans un template de page
- [ ] Un champ de formulaire = `<twig:Molecules:*Field>`, pas un `<input>` nu
- [ ] Pas de logique dupliquée entre deux composants — si ça existe déjà, l'utiliser
- [ ] Pas de composant Organism utilisé à l'intérieur d'un autre Organism (sauf cas justifié)
- [ ] Les composants reçoivent des données via props, pas via des requêtes Twig directes (`app.user` etc. restent dans les templates de pages)

### HTML sémantique
- [ ] Les titres suivent une hiérarchie logique (`h1` → `h2` → `h3`, pas de saut)
- [ ] Un seul `<h1>` par page
- [ ] `<main>`, `<header>`, `<footer>`, `<nav>`, `<section>`, `<article>` utilisés là où c'est pertinent
- [ ] Les images ont un `alt` (vide `alt=""` si décorative, descriptif si informative)
- [ ] Les formulaires ont des `<label>` associés à leurs champs

### Accessibilité
- [ ] Les boutons icon-only ont un `aria-label`
- [ ] Les éléments interactifs sont atteignables au clavier
- [ ] Pas de `tabindex` positif (`tabindex="1"`, `tabindex="2"`…)

### Logique & bricolage
- [ ] Pas de `href="/chemin"` hardcodé → `href="{{ path('nom_route') }}"`
- [ ] Pas de `{% if %}` ou `{% for %}` qui recrée ce qu'un composant existant fait déjà
- [ ] Pas de texte ou libellé codé en dur si ça devrait venir d'une prop ou d'une variable
- [ ] Pas de classe responsive dupliquée inutilement (`sm:hidden md:hidden lg:hidden` → `hidden`)
- [ ] Pas de `z-index` arbitraire sans commentaire justificatif
- [ ] Pas de `!important` via `!` Tailwind sauf cas extrême documenté
- [ ] Pas d'asset de test ou placeholder oublié (`logotest.svg`, images Lorem Picsum…)

### Modernité & cohérence visuelle
- [ ] Les espacements utilisent les tokens (`px-side`, `pt-top`) plutôt que des valeurs arbitraires sur les sections principales
- [ ] Les arrondis, ombres et transitions sont cohérents avec le reste du projet
- [ ] Pas de `cursor-pointer` sur un `<button>` (navigateurs le font nativement)
- [ ] Les états hover/focus sont définis pour tous les éléments interactifs

### SEO
- [ ] `{% block title %}` rempli avec un titre pertinent sur chaque page (pas juste hérité de `base.html.twig`)

### Live Components
- [ ] Les props modifiables depuis le template ont `#[LiveProp]`
- [ ] Les méthodes appelables depuis le template ont `#[LiveAction]`

### Stimulus
- [ ] Chaque `data-controller="foo"` a un controller `foo_controller.js` enregistré dans `stimulus_bootstrap.js`
- [ ] Chaque `data-action="foo#bar"` correspond à une méthode `bar()` qui existe dans le controller
- [ ] Chaque `data-foo-target="baz"` correspond à un target `baz` déclaré dans le controller (`static targets = ['baz']`)

### Sécurité
- [ ] Pas de `|raw` sans justification explicite (risque XSS)
- [ ] Les formulaires POST ont un token CSRF (`{{ form_rest(form) }}` ou `{{ csrf_token('intention') }}`)

### Performance & images
- [ ] Les `<img>` ont `width` et `height` définis (évite le layout shift)
- [ ] Les images sous la ligne de flottaison ont `loading="lazy"`
- [ ] Pas de boucle `{% for %}` qui déclenche des requêtes SQL en cascade (N+1) — les données doivent être pré-chargées dans le controller

### Responsive
- [ ] Pas de largeurs fixes qui cassent sur mobile (`w-[800px]`…) → préférer `max-w-*`
- [ ] Les textes longs ne débordent pas sur petits écrans (`break-words`, `truncate` si nécessaire)
- [ ] Le template a été vérifié aux breakpoints `sm` (mobile), `md` (tablette), `lg` (desktop)

---

## Patterns à éviter
| ❌ Interdit | ✅ À la place |
|------------|--------------|
| `href` sur `<twig:Atoms:Button>` | `<twig:Atoms:Link>` |
| `twig:Atoms:Nav` | `twig:Molecules:Nav` ou `twig:Molecules:NavigationLinks` |
| `decorative="true"` (string) | `:decorative="true"` (booléen) |
| `random()` pour générer des IDs dans Twig | getter PHP avec `bin2hex(random_bytes(4))` |
| Variables `{% set x = this.x %}` sur des props simples | Utiliser `x` directement |
| Deux composants faisant la même chose | Supprimer le doublon |
