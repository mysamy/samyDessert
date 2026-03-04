# samyDessert — Conventions de développement

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
- [ ] Pages à créer : `/produits`, `/recettes`, `/contact`, `/panier`, `/connexion`
- [ ] Entités Doctrine : Produit, Commande, Utilisateur
- [ ] Authentification Symfony Security
- [ ] Composant `ProductCard` branché sur de vraies données
- [ ] Composant `CartSummary` branché sur la session/panier
- [ ] Formulaire de contact fonctionnel
- [ ] Emails transactionnels (confirmation commande)

### Documentation & Soutenance
- [ ] Ajouter des commentaires dans le code (PHP + Twig + JS)
- [ ] Rédiger un résumé du projet (stack, architecture, choix techniques)
- [ ] Générer un questionnaire d'entraînement pour l'évaluation de fin de projet

## Patterns à éviter
| ❌ Interdit | ✅ À la place |
|------------|--------------|
| `href` sur `<twig:Atoms:Button>` | `<twig:Atoms:Link>` |
| `twig:Atoms:Nav` | `twig:Molecules:Nav` ou `twig:Molecules:NavigationLinks` |
| `decorative="true"` (string) | `:decorative="true"` (booléen) |
| `random()` pour générer des IDs dans Twig | getter PHP avec `bin2hex(random_bytes(4))` |
| Variables `{% set x = this.x %}` sur des props simples | Utiliser `x` directement |
| Deux composants faisant la même chose | Supprimer le doublon |
