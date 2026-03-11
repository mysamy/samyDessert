# samyDessert — Mémoire de travail

## Stack
- Symfony + Twig + Tailwind CSS (JIT) + Stimulus + Symfony UX Twig Components
- Serveur : `symfony serve` + `php bin/console tailwind:build --watch`

## Architecture des composants (Atomic Design)
- `templates/components/atoms/` + `src/Twig/Components/Atoms/`
- `templates/components/molecules/` + `src/Twig/Components/Molecules/`
- `templates/components/organisms/` + `src/Twig/Components/Organisms/`

## Règles Twig Components

### `this.` uniquement pour les getters PHP
- Propriété publique → accès direct : `{{ rows }}` ✅
- Getter/méthode → `this.` obligatoire : `{{ this.computedId }}` ✅
- `this.` sur une prop simple = inutile mais ne casse pas

### `this.` change de contexte dans les sous-composants
- À l'intérieur d'un bloc `<twig:Atoms:Link>`, `this` = Link, pas le parent
- Toujours extraire en `{% set %}` AVANT d'entrer dans un sous-composant :
  ```twig
  {% set logoAlt = logoAlt ?: brandLabel %}  {# avant le Link #}
  ```

### `attributes.defaults()` sur l'élément racine
- Permet la surcharge de class depuis l'appelant
- Ne pas mettre `class="{{ class }}"` direct, utiliser `attributes.defaults({ class: class })`

### Props vs Attributes
- Props déclarées en PHP = variables Twig directes
- Tout le reste va dans `attributes` (id, name, placeholder, data-*, aria-*)
- Ne pas redéclarer en PHP ce qui peut passer par attributes

## Règles PHP

### Props obligatoires
- Toujours mettre des valeurs par défaut : `public string $label = '';`
- `public string $label;` sans default → erreur PHP si non passé

### Getters calculés
- Préférer les getters aux props calculées stockées (évite désync)
- `mount()` pour initialisation complexe, sinon getter

### Calculs depuis collections
- Ne pas dupliquer : `$totalItems`, `$totalPrice` doivent être des getters calculés depuis `$items`

## Tailwind v4

- Config dans `assets/styles/app.css` (plus de `tailwind.config.js` en v4)
- Scanner les templates : `@source "../../templates/**/*.twig";`
- Après chaque modif CSS : `php bin/console tailwind:build`

## Docker

### Workflow dev
- `docker compose up -d --build` pour démarrer
- Service `assets` recompile Tailwind en boucle toutes les 3s (watch inotify non supporté sur Windows+Docker)
- `docker compose logs -f assets` pour voir les logs CSS

### TODO prod
- Supprimer le service `assets` du docker-compose
- Ajouter dans le Dockerfile PHP : `RUN php bin/console tailwind:build && php bin/console asset-map:compile`

## Stimulus

### Setup (Laragon)
- `assets/stimulus_bootstrap.js` démarre Stimulus manuellement :
  ```js
  import { Application } from '@hotwired/stimulus';
  import NavToggleController from './controllers/nav_toggle_controller.js';
  const app = Application.start();
  app.register('nav-toggle', NavToggleController);
  ```
- `assets/app.js` importe uniquement `./stimulus_bootstrap.js`
- NE PAS utiliser `startStimulusApp()` du bundle Symfony (controllers.js vide en mode compilé)
- Nommage : `nav_toggle_controller.js` → `data-controller="nav-toggle"`
- Toujours initialiser l'état dans `connect()`

### Workflow Laragon (IMPORTANT)
- Laragon sert `public/assets/` (fichiers compilés), PAS `assets/` directement
- Après chaque modif JS : `php bin/console asset-map:compile`
- Sans ça, le navigateur reçoit l'ancienne version

## Patterns à éviter
- `href` sur `<twig:Atoms:Button>` → Button = `<button>`, utiliser `twig:Atoms:Link` à la place
- `twig:Atoms:Nav` n'existe pas → utiliser `twig:Molecules:Nav` ou `twig:Molecules:NavigationLinks`
- `decorative="true"` (string) → `:decorative="true"` (booléen)
- Variables `{% set %}` extraites de `this.` inutiles quand c'est des props simples
- `random()` dans Twig pour générer des IDs → préférer un getter PHP avec `bin2hex(random_bytes(4))`
- Deux composants faisant la même chose (ex: Molecules/ProductCard supprimé car doublon de Organisms/ProductCard)

## Structure base.html.twig
- Ordre : Header → `<main>{% block body %}</main>` → Footer
- `lang="fr"` sur `<html>`
- Année copyright dynamique : `{{ 'now'|date('Y') }}`

## Préférence utilisateur
- À la fin de chaque session, ajouter un résumé dans "Historique des sessions" ci-dessous
- Copier ensuite dans `.claude/memory/MEMORY.md` (dans le repo) pour portabilité entre PCs
- Le repo contient `.claude/memory/MEMORY.md` — le committer après chaque session importante

## Historique des sessions

### 2026-03-11 — Configuration Docker
- Ajout service `assets` dans `docker-compose.yml` pour recompiler Tailwind en boucle (watch inotify ne fonctionne pas Docker+Windows)
- Commande : `while true; do php bin/console tailwind:build; sleep 3; done` avec `restart: unless-stopped`
- Problème résolu : `asset-map:compile` avait créé `public/assets/` → bloquait le service dynamique des assets en mode dev → fix : `docker compose exec php rm -rf public/assets`
- `asset-map:compile` est inutile en mode dev (Symfony ignore les fichiers compilés en debug mode)
- Ajout `.claude/memory/MEMORY.md` dans le repo git pour portabilité entre PCs
