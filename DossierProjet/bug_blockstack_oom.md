# Bug : OOM dans BlockStack — pages /recettes et /produits/{slug}

## Symptôme
`Error: Allowed memory size of 1073741824 bytes exhausted` sur :
- `/recettes`
- `/produits/{slug}` (ex: `/produits/eclair-au-chocolat`)

Pages qui fonctionnent : `/`, `/produits`, `/contact`, `/panier`

Stack trace : `vendor/symfony/ux-twig-component/src/BlockStack.php` ligne 76

## Cause identifiée (partielle)

`BlockStack::findHostEmbeddedTemplateIndex()` appelle `debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)` à chaque rendu d'un composant Twig qui contient un `{% block %}`. Avec un call stack suffisamment profond, ça consomme toute la mémoire.

### Composant fautif confirmé : `Badge`

Par isolement progressif (commenter/décommenter des blocs), on a isolé que `<twig:Atoms:Badge>` est le déclencheur du crash :
- `<twig:Atoms:Link>` (même structure, `{% block content %}`) → **ne crashe pas**
- `<twig:Atoms:Badge>` → **crashe systématiquement**

Badge est utilisé sur les pages qui crashent :
- `/recettes` → DessertCard rend Badge (champ `difficulte`)
- `/produits/{slug}` → Badge pour la catégorie du produit

Badge **n'est pas** utilisé sur `/produits` (liste) ni `/contact` → ces pages fonctionnent.

### Hypothèse de cause (non confirmée)
`Badge.html.twig` avait un `{% set variants = {...} %}` **avant** l'élément racine `<span>`. En Twig UX, tout code avant la racine crée un niveau d'embedded template supplémentaire, ce qui peut décaler les index que BlockStack utilise pour résoudre les blocs → boucle infinie / OOM.

Tentative de fix : supprimer le `{% set %}` et inliner la logique dans `attributes.defaults()`.
**Résultat : toujours en échec.** Cause réelle non encore trouvée.

## Pistes explorées et écartées

### Barre de debug Symfony (Web Profiler)
Première hypothèse : le profiler Symfony ajoute des couches de stack frames, ce qui alourdit chaque appel `debug_backtrace` dans BlockStack.

Actions :
- Création de `config/packages/dev/web_profiler.yaml` : `toolbar: false`, `profiler.enabled: false`
- Création de `config/packages/dev/twig_component.yaml` : `collect_components: false`
- Modification de `config/packages/doctrine.yaml` : `profiling_collect_backtrace: false` (était `true` en dev, loggait la backtrace complète pour chaque requête SQL)

**Résultat : crash persistant même sans profiler.** Le profiler aggravait le problème mais n'en était pas la cause racine.

### Mémoire PHP insuffisante
`memory_limit` passé de 256M à 512M dans `docker/php/Dockerfile`.
**Résultat : crash toujours présent** (juste à 1GB au lieu de 256M).

### Patch BlockStack vendor
Tentative de modifier `BlockStack::findHostEmbeddedTemplateIndex()` pour :
- Retirer `DEBUG_BACKTRACE_PROVIDE_OBJECT` (ne charge plus les objets en mémoire)
- Limiter la profondeur à 50 frames
- Utiliser `$trace['class']` + `is_a()` au lieu des objets instanciés

**Résultat : crash persistant**, et le patch risquait d'introduire une mauvaise résolution des blocs → boucle infinie. Patch annulé (revert).

### Cache Windows vs Docker
Symptôme : `php bin/console cache:clear` depuis Windows générait un cache incompatible avec PHP-FPM dans Docker.
**Fix : toujours vider le cache depuis Docker** :
```bash
docker compose exec php php bin/console cache:clear
```

## Méthodologie de débogage utilisée

1. Confirmer les pages qui marchent vs crashent
2. Désactiver le profiler Symfony (`web_profiler.yaml`, `twig_component.yaml`) → n'a pas suffi
3. Augmenter `memory_limit` Docker (256M → 512M) → n'a pas suffi
4. Vider le cache dans Docker : `docker compose exec php php bin/console cache:clear`
5. **Isolation par commentaire progressif** dans les templates :
   - Vider complètement `{% block body %}` → marche ✅
   - Rajouter hero (HTML pur) → marche ✅
   - Rajouter SearchBar + `<twig:block name="extra_inputs">` → marche ✅
   - Rajouter sidebar avec `twig:Atoms:Link` → marche ✅
   - Rajouter 1 DessertCard hardcodée (sans difficulte) → marche ✅
   - Ajouter `favoriUrl` → marche ✅
   - Vraie boucle recettes → crashe ❌
   - Vraie boucle slice(0,1) → crashe ❌
   - Props minimales (titre, url, favoriUrl) sur entité réelle → marche ✅
   - Ajouter `difficulte="Facile"` (hardcodé) → crashe ❌
   - Badge directement sur la page → crashe ❌
   - Remplacer Badge par Link → marche ✅
   - **Conclusion : Badge est le composant fautif**

## État actuel (à résoudre)

- `Badge.html.twig` : `{% set %}` supprimé, logique inlinée — toujours en crash
- Templates recettes et show partiellement restaurés

## Pistes pour la suite

- Comparer le PHP compilé de Badge vs Link dans le cache Twig (`var/cache/dev/twig/`)
- Regarder si le nom explicite `#[AsTwigComponent('Atoms:Badge')]` vs implicite affecte l'index
- Tester avec un composant identique à Badge mais renommé différemment
- Ouvrir une issue sur `symfony/ux` avec un cas minimal reproductible
