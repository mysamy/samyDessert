# Checklist — relire un template avant de valider

```bash
php bin/console lint:twig templates/
```

### Couleurs & tokens
- [ ] Pas de `bg-white` → `bg-surface` ou `bg-bg`
- [ ] Pas de `text-red-*` / `bg-red-*` → `text-danger` / `bg-danger-light`
- [ ] Pas de couleurs Tailwind brutes (`gray-*`, `amber-*`, `rose-*`…) → token du projet
- [ ] `border-surface` = **faux** → `border-border`

### Classes CSS
- [ ] Toute classe custom existe dans `app.css`
- [ ] Pas de style inline sauf cas impossible autrement
- [ ] Éviter les valeurs arbitraires (`w-[1.5rem]`…) quand une classe standard suffit

### Composants Twig
- [ ] `:decorative="true"` (booléen, pas string)
- [ ] `this.prop` sur prop simple → utiliser `prop` directement
- [ ] `this.getter` dans sous-composant → extraire en `{% set %}` avant
- [ ] Élément racine a `{{ attributes.defaults({ class: '...' }) }}`
- [ ] Pas de prop PHP déclarée si jamais utilisée

### Atomic Design
- [ ] Bouton = `<twig:Atoms:Button>` ou `<twig:Atoms:Link>`, jamais `<button>`/`<a>` nu
- [ ] Champ = `<twig:Molecules:*Field>`, pas `<input>` nu
- [ ] Pas de logique dupliquée entre composants
- [ ] Pas d'Organism dans un Organism (sauf justifié)
- [ ] Composants reçoivent données via props, pas via requêtes Twig directes

### HTML sémantique
- [ ] Hiérarchie des titres logique, un seul `<h1>` par page
- [ ] Balises sémantiques (`<main>`, `<nav>`, `<section>`…) utilisées
- [ ] Images : `alt` descriptif ou `alt=""` si décorative
- [ ] Formulaires : `<label>` associés aux champs

### Accessibilité
- [ ] Boutons icon-only ont un `aria-label`
- [ ] Éléments interactifs atteignables au clavier
- [ ] Pas de `tabindex` positif

### Logique
- [ ] Pas de `href="/chemin"` hardcodé → `path('nom_route')`
- [ ] Pas de `{% if %}`/`{% for %}` qui recrée ce qu'un composant fait déjà
- [ ] Pas de classe responsive dupliquée (`sm:hidden md:hidden` → `hidden`)
- [ ] Pas de `z-index` arbitraire sans commentaire
- [ ] Pas d'asset de test oublié

### Cohérence visuelle
- [ ] Espacements via tokens (`px-side`, `pt-top`) sur les sections principales
- [ ] Pas de `cursor-pointer` sur `<button>`
- [ ] États hover/focus définis pour tous les éléments interactifs

### SEO
- [ ] `{% block title %}` rempli sur chaque page

### Live Components
- [ ] Props modifiables → `#[LiveProp]` ; méthodes appelables → `#[LiveAction]`

### Stimulus
- [ ] `data-controller="foo"` → `foo_controller.js` enregistré dans `stimulus_bootstrap.js`
- [ ] `data-action="foo#bar"` → méthode `bar()` existe
- [ ] `data-foo-target="baz"` → `static targets = ['baz']` déclaré

### Sécurité
- [ ] Pas de `|raw` sans justification (risque XSS)
- [ ] Formulaires POST ont un token CSRF

### Performance & images
- [ ] `<img>` ont `width` et `height`
- [ ] Images sous la ligne de flottaison ont `loading="lazy"`
- [ ] Pas de N+1 dans les boucles `{% for %}`

### Responsive
- [ ] Pas de largeurs fixes (`w-[800px]`) → `max-w-*`
- [ ] Vérifié aux breakpoints `sm`, `md`, `lg`
