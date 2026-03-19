# assets/ — Sources JS et CSS

Contient les fichiers **sources** JavaScript et CSS qu'on édite directement.
Ne pas confondre avec `public/assets/` qui contient les fichiers **compilés** pour le navigateur.

---

## Structure

```
assets/
├── app.js                  # Point d'entrée JS principal — importe Stimulus
├── stimulus_bootstrap.js   # Démarre Stimulus et enregistre tous les controllers
│
├── controllers/            # Controllers Stimulus (interactions JS)
│   ├── carousel_controller.js      # Carousel de la page d'accueil
│   ├── nav_toggle_controller.js    # Menu mobile (ouverture/fermeture)
│   ├── dropdown_controller.js      # Menus déroulants
│   └── csrf_protection_controller.js # Protection CSRF pour les formulaires
│
├── styles/
│   └── app.css             # CSS principal — Tailwind v4 + couleurs personnalisées
│
└── image/                  # Images référencées dans les assets
```

---

## Comment fonctionne le CSS (Tailwind v4)

`app.css` utilise Tailwind CSS v4. Il contient :

```css
@import "tailwindcss";          /* charge Tailwind */
@source "../../templates/**/*.twig";  /* scanne les templates pour générer les classes */

@theme {
  --color-amber-*: ...;         /* palette de couleurs personnalisée */
}
```

Après chaque modification de `app.css` ou des templates Twig :
→ Le container Docker `assets` recompile automatiquement toutes les 10 secondes.

---

## Comment fonctionnent les controllers Stimulus

Stimulus est un framework JS léger. Chaque controller est lié à un élément HTML via `data-controller`.

```html
<!-- HTML -->
<div data-controller="carousel">...</div>
```

```javascript
// assets/controllers/carousel_controller.js
export default class extends Controller {
  // logique du carousel
}
```

Après modification d'un controller JS, le container `assets` recompile automatiquement.

---

## Flux de compilation

```
assets/styles/app.css  →  tailwind:build  →  var/tailwind/app.built.css
assets/app.js          →                  ↘
assets/controllers/    →  asset-map:compile →  public/assets/  (servi par nginx)
```
