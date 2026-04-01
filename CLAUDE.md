# samyDessert — Conventions de développement

## Début de conversation
- Relire `MEMORY.md` + fichiers liés avant de commencer

## Stack
- Symfony + Twig + Tailwind CSS v4 (JIT) + Stimulus + Symfony UX Twig Components
- Dev : `symfony serve` + `php bin/console tailwind:build --watch`
- Après modif JS : `php bin/console asset-map:compile`

## Architecture Atomic Design
- `templates/components/atoms|molecules|organisms/` + `src/Twig/Components/Atoms|Molecules|Organisms/`

## Règles Twig Components

- Props publiques PHP → variable Twig directe (`{{ rows }}`). Getters → `this.` (`{{ this.computedId }}`)
- Dans un sous-composant, `this` change de contexte → extraire en `{% set %}` avant d'entrer
- Élément racine → `{{ attributes.defaults({ class: '...' }) }}` pour permettre la surcharge
- Props PHP déclarées → toujours une valeur par défaut (`public string $label = '';`)
- Ce qui peut passer par `attributes` (id, name, data-*, aria-*) ne se déclare pas en PHP

## Règles PHP
- Getters pour valeurs calculées, jamais de prop stockée qui peut se désynchroniser
- Valeurs par défaut obligatoires sur toutes les props

## Tailwind v4
- Pas de `tailwind.config.js` — tout dans `assets/styles/app.css`
- Après chaque modif CSS : `php bin/console tailwind:build`

## Stimulus
- `stimulus_bootstrap.js` : `Application.start()` + enregistrement manuel des controllers

## TODO
- [ ] Afficher/masquer le mot de passe (connexion/inscription)
- [ ] Emails transactionnels (confirmation commande)
- [ ] Déplacer `docker/` et `docker-compose.yml` hors du dossier projet
- [ ] Système d'avis (entité `Avis`, note moyenne sur DessertCard)
- [ ] Commentaires dans le code (PHP + Twig + JS)
- [ ] Résumé projet + questionnaire d'entraînement pour la soutenance
- [ ] Gestion des images : VichUploaderBundle + stockage local (`public/uploads/`) + formulaire upload dans l'admin

## Référence rapide

### Routes Symfony
| Route | URL |
|-------|-----|
| `app_home` | `/` |
| `app_produits` | `/produits` |
| `app_produit_show` | `/produits/{slug}` |
| `app_recettes` | `/recettes` |
| `app_recette_show` | `/recettes/{slug}` |
| `app_panier_index` | `/panier` |
| `app_panier_ajouter` | `POST /panier/ajouter/{id}` |
| `app_panier_retirer` | `POST /panier/retirer/{id}` |
| `app_panier_supprimer` | `POST /panier/supprimer/{id}` |
| `app_panier_vider` | `POST /panier/vider` |
| `app_commande` | `/commande` |
| `app_login` | `/connexion` |
| `app_register` | `/inscription` |
| `app_contact` | `/contact` |
| `app_compte_index` | `/mon-compte` |
| `app_favori_toggle` | `POST /favori/{type}/{id}` |

### Classes CSS custom (`assets/styles/app.css`)
| Classe | Usage |
|--------|-------|
| `btn-cta` | CTA grand, fond framboise, `px-8 py-3 rounded-full` |
| `btn-cta-sm` | CTA compact, fond framboise, `px-4 py-2 rounded-full` |
| `btn-cta-outline` | CTA contour framboise |
| `btn-cta__icon` | Icône dans btn-cta (avance au hover) |
| `nav-link` | Lien avec trait souligné animé (croît du centre) |
| `page-title` | `<h1>` de page |
| `section-title` | Titre de section |
| `section-alt` | Section fond alternatif |
| `divider` | Séparateur horizontal |

### Emplacements clés
- **Dialog sidebar panier** : `templates/base.html.twig`
- **Contenu panier (live)** : `templates/components/organisms/PanierLive.html.twig`
- **Bouton ajouter au panier** : `templates/components/molecules/BoutonPanier.html.twig`
- **Carte produit/recette** : `templates/components/molecules/DessertCard.html.twig`
- **Tokens CSS** : début de `assets/styles/app.css`

## Patterns à éviter
| ❌ | ✅ |
|----|-----|
| `href` sur `<twig:Atoms:Button>` | `<twig:Atoms:Link>` |
| `decorative="true"` (string) | `:decorative="true"` (booléen) |
| `random()` pour IDs dans Twig | getter PHP `bin2hex(random_bytes(4))` |
| `{% set x = this.x %}` sur prop simple | utiliser `x` directement |
| Deux composants faisant la même chose | supprimer le doublon |
| `href="/chemin"` hardcodé | `path('nom_route')` |

## Checklist template
→ Voir `CHECKLIST.md` (lint, tokens, atomic design, a11y, perf, responsive…)
