# Questionnaire d'entraînement — Oral SamyDessert

> **Mode d'emploi** : lis chaque question, note ta réponse, puis vérifie avec la correction en bas de section.
> Les questions vont du plus simple au plus complexe.

---

## PARTIE 1 — HTML & Sémantique

**Q1.** Quelle est la balise HTML utilisée pour les cartes produits dans `ProductCardGrid` ?
- A) `<div>`
- B) `<section>`
- C) `<article>`
- D) `<li>`

**Q2.** Quelle attribut HTML est utilisé sur une icône purement décorative pour qu'elle soit ignorée par les lecteurs d'écran ?
- A) `role="none"`
- B) `aria-hidden="true"`
- C) `tabindex="-1"`
- D) `alt=""`

**Q3.** Quel attribut indique au lecteur d'écran que le lien de navigation correspond à la page courante ?
- A) `aria-selected="true"`
- B) `aria-active="true"`
- C) `aria-current="page"`
- D) `data-current="true"`

**Q4.** Dans `base.html.twig`, quel est le titre par défaut de la page si le bloc `{% block title %}` n'est pas redéfini ?
- A) `"SamyDessert"`
- B) `"Samy Dessert"`
- C) `"Artisan Pâtissier"`
- D) `"Accueil"`

**Q5.** Quelle balise HTML native est utilisée pour le menu mobile et les boîtes de dialogue de confirmation ?
- A) `<modal>`
- B) `<popup>`
- C) `<dialog>`
- D) `<aside>`

**Q6.** Quel attribut relie un champ `<input>` à son message d'aide pour les lecteurs d'écran ?
- A) `aria-label`
- B) `aria-describedby`
- C) `aria-controls`
- D) `aria-details`

**Q7.** Dans le carousel, quel attribut ARIA est mis à `"false"` sur les slides non visibles ?
- A) `aria-visible`
- B) `aria-disabled`
- C) `aria-hidden`
- D) `aria-inactive`

**Q8.** Pourquoi utilise-t-on `<ul role="list">` dans la grille de produits ?
- A) Pour appliquer un style CSS
- B) Parce que certains navigateurs retirent la sémantique de liste quand `list-style: none` est appliqué
- C) Pour que Symfony reconnaisse la liste
- D) C'est une exigence de Twig Components

---

**Corrections partie 1 :** 1-C / 2-B / 3-C / 4-B / 5-C / 6-B / 7-C / 8-B

---

## PARTIE 2 — CSS & Tailwind v4

**Q9.** Dans Tailwind v4, où sont définis les tokens de couleurs et d'espacement du projet ?
- A) Dans `tailwind.config.js`
- B) Dans `assets/styles/app.css` via la directive `@theme`
- C) Dans `config/packages/tailwind.yaml`
- D) Dans `assets/app.js`

**Q10.** Quelle valeur CSS est assignée au token `--color-accent` du projet ?
- A) `#5C2309` (chocolat foncé)
- B) `#3F6212` (pistache)
- C) `#9D174D` (framboise foncée)
- D) `#DC2626` (rouge danger)

**Q11.** Quelle est la différence entre `focus:outline` et `focus-visible:outline` en Tailwind ?
- A) Aucune différence, ce sont des alias
- B) `focus:` s'applique toujours, `focus-visible:` s'applique uniquement lors de la navigation clavier
- C) `focus-visible:` fonctionne uniquement sur Firefox
- D) `focus:` est déprécié en Tailwind v4

**Q12.** Quelle technique CSS est utilisée pour les marges latérales (`px-side`) afin qu'elles s'adaptent automatiquement à la taille de l'écran ?
- A) `media queries`
- B) `vw` fixe
- C) `clamp()`
- D) `calc()`

**Q13.** Quelle directive Tailwind v4 est utilisée pour regrouper des combinaisons de classes réutilisables comme `.btn-cta` ou `.card` ?
- A) `@apply` seul dans le fichier root
- B) `@layer components { ... }`
- C) `@extend`
- D) `@utility`

**Q14.** Pourquoi les styles du carousel sont-ils définis en CSS classique plutôt qu'avec des classes Tailwind dans le HTML ?
- A) Tailwind ne supporte pas les animations
- B) Les classes CSS du carousel sont générées dynamiquement par le JavaScript (`createDivWithClass`), elles ne sont donc pas présentes dans le HTML scanné par Tailwind
- C) C'est une préférence personnelle
- D) Tailwind est trop lent pour le carousel

**Q15.** Quel token faut-il utiliser à la place de `bg-white` dans ce projet ?
- A) `bg-surface` ou `bg-bg`
- B) `bg-light`
- C) `bg-neutral`
- D) `bg-cream`

**Q16.** Quelle propriété CSS est définie sur `html` pour éviter un saut visuel de ~17px lorsque la scrollbar apparaît ou disparaît ?
- A) `overflow: stable`
- B) `scrollbar-width: thin`
- C) `scrollbar-gutter: stable`
- D) `scroll-behavior: smooth`

**Q17.** Que fait `font-display: swap` dans les règles `@font-face` de la police Luciole ?
- A) Charge la police en priorité absolue, bloquant le rendu
- B) Affiche d'abord une police système, puis remplace par Luciole quand elle est chargée
- C) Désactive le chargement de la police sur mobile
- D) Rend la police disponible uniquement en production

---

**Corrections partie 2 :** 9-B / 10-C / 11-B / 12-C / 13-B / 14-B / 15-A / 16-C / 17-B

---

## PARTIE 3 — JavaScript & Stimulus

**Q18.** Comment Stimulus associe un controller à un élément HTML ?
- A) Via un `id` HTML
- B) Via l'attribut `data-controller="nom-du-controller"`
- C) Via une classe CSS
- D) Via un `querySelector` dans le JS

**Q19.** Dans `stimulus_bootstrap.js`, quelle méthode est utilisée pour enregistrer les controllers ?
- A) `Stimulus.load()`
- B) `app.register('nom', ControllerClass)`
- C) `registerController('nom', ControllerClass)`
- D) `startStimulusApp()`

**Q20.** Combien de controllers Stimulus sont enregistrés dans le projet ?
- A) 7
- B) 9
- C) 11
- D) 13

**Q21.** Que se passe-t-il dans le controller `submit-once` quand un formulaire est soumis ?
- A) Il redirige l'utilisateur vers une page de confirmation
- B) Il désactive le bouton, masque le label, affiche le spinner et ajoute `aria-busy="true"`
- C) Il envoie les données en AJAX
- D) Il valide les champs du formulaire

**Q22.** Dans le controller `favori`, quelle réponse HTTP déclenche l'affichage d'un message "Connectez-vous" via le `flash-tooltip` ?
- A) 403
- B) 404
- C) 401
- D) 500

**Q23.** Comment le controller `favori` communique-t-il avec le controller `flash-tooltip` ?
- A) Via un événement DOM `dispatchEvent`
- B) Via un appel de fonction directe
- C) Via le mécanisme d'**outlets** Stimulus
- D) Via `localStorage`

**Q24.** Dans le carousel, comment l'effet de défilement infini est-il créé ?
- A) En rechargeant les slides en AJAX
- B) En clonant les premiers et derniers éléments et en se repositionnant silencieusement après la transition
- C) En utilisant une boucle CSS `animation`
- D) En réordonnant le DOM après chaque slide

**Q25.** Quel événement JavaScript est écouté dans le carousel pour savoir quand une transition CSS est terminée ?
- A) `animationend`
- B) `transitionend`
- C) `slideend`
- D) `moveend`

**Q26.** Dans le controller `nav-toggle`, dans quelle situation le menu mobile se ferme-t-il automatiquement sans action de l'utilisateur ?
- A) Après 5 secondes
- B) Quand l'utilisateur fait défiler la page
- C) Quand la fenêtre est redimensionnée en mode desktop (≥ 768px) ou quand Échap est pressé
- D) Quand un lien est cliqué

---

**Corrections partie 3 :** 18-B / 19-B / 20-C / 21-B / 22-C / 23-C / 24-B / 25-B / 26-C

---

## PARTIE 4 — PHP & Symfony

**Q27.** Quelle interface PHP Symfony doit implémenter l'entité `Utilisateur` pour être utilisée dans le système d'authentification ?
- A) `AuthenticatableInterface`
- B) `UserInterface` et `PasswordAuthenticatedUserInterface`
- C) `SecurityUserInterface`
- D) `LoginableInterface`

**Q28.** Quel est le rôle de la classe `UserChecker` dans ce projet ?
- A) Vérifier que le mot de passe respecte les règles de complexité
- B) Bloquer la connexion si le compte n'a pas encore été vérifié par email
- C) Limiter le nombre de tentatives de connexion
- D) Chiffrer les mots de passe

**Q29.** Comment le token de vérification d'email est-il généré dans `SecurityController` ?
- A) `md5(uniqid())`
- B) `Uuid::v4()`
- C) `bin2hex(random_bytes(32))`
- D) `sha1($user->getEmail())`

**Q30.** Quel attribut PHP protège les routes de `CommandeController` et `CompteController` contre les utilisateurs non connectés ?
- A) `#[RequireLogin]`
- B) `#[Security('is_granted("ROLE_USER")')` ]
- C) `#[IsGranted('ROLE_USER')]`
- D) `#[Login(required: true)]`

**Q31.** Dans le `PanierService`, quelle est la structure du panier stocké en session ?
- A) Un tableau d'objets `Produit`
- B) Un tableau associatif `[produitId => quantite]`
- C) Un objet JSON
- D) Un tableau d'entités `CommandeProduit`

**Q32.** Que fait `PasswordUpgraderInterface` implémenté par `UtilisateurRepository` ?
- A) Force les utilisateurs à changer leur mot de passe tous les 3 mois
- B) Met à jour automatiquement le hash du mot de passe si l'algorithme de hachage évolue, lors de la prochaine connexion
- C) Valide la complexité du mot de passe
- D) Envoie un email quand le mot de passe est changé

**Q33.** Quel est le type de retour de `getEffectiveMethod()` dans `Form.php`, et que retourne-t-il si on lui passe `'PUT'` ?
- A) `bool`, retourne `false`
- B) `string`, retourne `'put'`
- C) `string`, retourne `'post'` (fallback)
- D) Lance une exception

**Q34.** Quelle est la différence entre un `LiveProp` et une prop normale dans un Twig Component ?
- A) Un `LiveProp` est public, une prop normale est privée
- B) Un `LiveProp` peut être modifié depuis le template (re-render réactif), une prop normale est en lecture seule
- C) Un `LiveProp` est stocké en session
- D) Il n'y a aucune différence fonctionnelle

**Q35.** Pourquoi les prix sont-ils stockés en `DECIMAL(8,2)` dans la base de données plutôt qu'en `FLOAT` ?
- A) `DECIMAL` est plus rapide que `FLOAT`
- B) `FLOAT` n'est pas supporté par MySQL
- C) `FLOAT` introduit des erreurs d'arrondi sur les calculs financiers, `DECIMAL` garantit une précision exacte
- D) `DECIMAL` prend moins de place en base de données

**Q36.** Dans `CommandeProduit`, pourquoi le prix unitaire est-il stocké en base de données au moment de la commande ?
- A) Pour optimiser les requêtes SQL
- B) Pour conserver un historique fidèle même si le prix du produit change dans le futur
- C) Parce que Doctrine l'exige pour les tables de jointure
- D) Pour éviter une jointure SQL

**Q37.** Qu'est-ce qu'un **backed enum** en PHP 8.1, et comment est-il utilisé dans ce projet ?
- A) Un enum qui hérite d'une classe parente
- B) Un enum associé à une valeur scalaire (`string` ou `int`), permettant la conversion vers/depuis cette valeur. Utilisé pour `StatutCommande` et `Difficulte`, stockés directement en base de données via Doctrine
- C) Un enum avec des méthodes statiques
- D) Un enum importé depuis une bibliothèque externe

---

**Corrections partie 4 :** 27-B / 28-B / 29-C / 30-C / 31-B / 32-B / 33-C / 34-B / 35-C / 36-B / 37-B

---

## PARTIE 5 — Twig Components & Atomic Design

**Q38.** Dans un Twig Component, quand utilise-t-on `this.propName` plutôt que `propName` directement dans le template ?
- A) Toujours, pour être explicite
- B) Uniquement pour les getters PHP (méthodes `get*()`) ; les props publiques s'utilisent directement
- C) Quand la prop est de type `bool`
- D) Uniquement dans les organismes

**Q39.** Quelle méthode Twig permet de définir des classes CSS par défaut sur un composant tout en permettant leur surcharge depuis l'extérieur ?
- A) `attributes.merge()`
- B) `attributes.defaults()`
- C) `attributes.add()`
- D) `attributes.override()`

**Q40.** Quel est le problème si on utilise `this.getter` à l'intérieur d'un sous-composant `<twig:Atoms:Link>` ?
- A) Cela provoque une erreur de syntaxe Twig
- B) `this` dans le sous-composant référence le `Link`, pas le composant parent — la valeur sera erronée ou vide
- C) Les getters ne sont pas accessibles depuis les sous-composants
- D) Il n'y a aucun problème

**Q41.** Quelle est la différence entre un **Atom** et une **Molecule** dans l'Atomic Design tel qu'il est implémenté dans ce projet ?
- A) Les atoms sont en PHP, les molecules en Twig
- B) Un atom est un élément HTML unique non décomposable (bouton, input, icône). Une molecule assemble plusieurs atoms pour une fonction précise (champ de formulaire = Label + Input + message d'erreur)
- C) Les molecules sont plus grandes visuellement
- D) Il n'y a pas de règle stricte

**Q42.** Combien de props déclare la classe PHP du composant `Button` ?
- A) 3
- B) 4
- C) 5
- D) 7

**Q43.** Dans `BoutonPanier`, comment le compteur du panier dans le header est-il mis à jour après un ajout ?
- A) Via un rechargement complet de la page
- B) Via `window.location.reload()`
- C) Via l'émission d'un événement `panierUpdated` qui est capté par le composant `PanierBadge`
- D) Via une requête AJAX vers le serveur

**Q44.** Qu'est-ce que la méthode `mount()` dans un Twig Component ?
- A) Un hook appelé à la destruction du composant
- B) Un hook du cycle de vie appelé à l'instanciation du composant, avant le rendu — permet d'initialiser des données dynamiques
- C) Une méthode pour monter le composant dans le DOM
- D) La méthode principale de rendu du composant

**Q45.** Dans `NavigationLinks`, quelle différence y a-t-il entre la détection du lien `/` et celle de `/produits` ?
- A) Aucune, les deux utilisent `===`
- B) `/` utilise `str_starts_with`, `/produits` utilise `===`
- C) `/` utilise `===` (correspondance exacte), `/produits` utilise `str_starts_with` pour rester actif sur `/produits/macaron-framboise`
- D) Les deux utilisent `str_contains`

---

**Corrections partie 5 :** 38-B / 39-B / 40-B / 41-B / 42-C / 43-C / 44-B / 45-C

---

## PARTIE 6 — Sécurité

**Q46.** Quelle algorithme de hachage de mot de passe est configuré dans `security.yaml` ?
- A) `bcrypt` fixe
- B) `argon2i`
- C) `'auto'` — Symfony choisit le meilleur algorithme disponible sur le serveur
- D) `sha256`

**Q47.** Qu'est-ce qu'une attaque CSRF et comment le projet s'en protège-t-il ?
- A) Une attaque qui intercepte les mots de passe. Protection : HTTPS
- B) Une attaque qui force un utilisateur connecté à effectuer une action non désirée via une requête frauduleuse. Protection : token CSRF unique par formulaire, vérifié côté serveur
- C) Une attaque par injection SQL. Protection : requêtes préparées
- D) Une attaque par déni de service. Protection : rate limiting

**Q48.** Pourquoi le montant total du paiement Stripe est-il recalculé côté serveur dans `CommandeController` ?
- A) Stripe l'exige dans ses CGU
- B) Pour éviter qu'un utilisateur malveillant modifie le prix dans le navigateur (via les outils de développement) avant de soumettre le formulaire
- C) Pour économiser des appels API
- D) Parce que le panier n'est pas accessible côté client

**Q49.** Quelle est la route de connexion configurée dans `security.yaml` de ce projet ?
- A) `/login`
- B) `/auth`
- C) `/connexion`
- D) `/signin`

**Q50.** Pourquoi `FavoriController` renvoie-t-il un `JsonResponse` avec le statut 401 plutôt qu'une redirection vers la page de connexion ?
- A) C'est une exigence de Symfony
- B) Parce que l'appel est fait en AJAX — une redirection n'aurait pas l'effet voulu. Le controller Stimulus gère le 401 et affiche un message à la place
- C) Pour économiser une requête HTTP
- D) Parce que `redirectToRoute` ne fonctionne pas dans ce controller

**Q51.** Que vérifie `CompteController` avant d'autoriser l'annulation d'une commande ?
- A) Uniquement que l'utilisateur est connecté
- B) Uniquement que la commande existe
- C) Que le token CSRF est valide, que la commande appartient à l'utilisateur connecté ET que son statut est `Confirmee`
- D) Que la commande a été passée il y a moins de 24h

---

**Corrections partie 6 :** 46-C / 47-B / 48-B / 49-C / 50-B / 51-C

---

## PARTIE 7 — Base de données & Doctrine

**Q52.** Quelle annotation Doctrine est utilisée pour définir une relation "un utilisateur a plusieurs commandes" ?
- A) `#[ORM\OneToOne]`
- B) `#[ORM\ManyToOne]` côté Commande
- C) `#[ORM\ManyToMany]`
- D) `#[ORM\HasMany]`

**Q53.** Dans `CommandeProduit`, la clé primaire est composite. Qu'est-ce que cela signifie ?
- A) Il y a deux colonnes `id` auto-incrémentées
- B) La clé primaire est formée par la combinaison de deux colonnes : `commande_id` + `produit_id` — leur association est unique
- C) La table n'a pas de clé primaire
- D) La clé primaire est un UUID

**Q54.** Que se passe-t-il en base de données si un utilisateur est supprimé, selon la configuration `onDelete: 'CASCADE'` de l'entité `Commande` ?
- A) La suppression est bloquée si l'utilisateur a des commandes
- B) Les colonnes `utilisateur_id` sont mises à `NULL`
- C) Toutes les commandes liées à cet utilisateur sont automatiquement supprimées
- D) Rien, il faut gérer ça manuellement

**Q55.** Quelle est la requête `findMeilleursVendus()` dans `ProduitRepository` et pourquoi fait-elle une jointure gauche (`leftJoin`) plutôt qu'une jointure interne (`innerJoin`) ?
- A) Pour des raisons de performance
- B) Pour inclure les produits disponibles même s'ils n'ont jamais été commandés (sinon ils seraient exclus par un `innerJoin`)
- C) Doctrine ne supporte pas `innerJoin`
- D) Pour éviter les doublons

**Q56.** Comment Doctrine est-il configuré pour utiliser les enums PHP dans les colonnes de base de données ?
- A) Via un type Doctrine personnalisé
- B) Via `type: 'string', enumType: StatutCommande::class` dans l'attribut `#[ORM\Column]`
- C) Via un `ValueConverter`
- D) Les enums ne sont pas supportés nativement par Doctrine

---

**Corrections partie 7 :** 52-B / 53-B / 54-C / 55-B / 56-B

---

## PARTIE 8 — Architecture & Choix techniques

**Q57.** Pourquoi AssetMapper est-il utilisé à la place de Webpack Encore dans ce projet ?
- A) Webpack Encore n'est plus maintenu
- B) AssetMapper est natif Symfony, ne nécessite pas Node.js ni d'étape de bundling — il utilise les import maps du navigateur pour charger les modules ES directement
- C) AssetMapper est plus rapide en développement
- D) Webpack Encore ne supporte pas Tailwind v4

**Q58.** Pourquoi la variable globale `panierCount` est-elle injectée via une extension Twig (`PanierExtension`) plutôt qu'être passée dans chaque controller ?
- A) Symfony l'exige pour les Live Components
- B) Pour centraliser la logique et éviter de la dupliquer dans chaque controller — la variable est disponible dans tous les templates automatiquement
- C) Pour des raisons de performance
- D) Parce que Twig Components n'ont pas accès aux variables de controller

**Q59.** Pourquoi `app.js` contient-il uniquement `import './stimulus_bootstrap.js'` ?
- A) C'est une limitation d'AssetMapper
- B) C'est voulu : séparer le point d'entrée de la configuration Stimulus maintient le code organisé et facilite l'ajout de nouveaux controllers
- C) Les autres imports sont chargés automatiquement
- D) Par manque de temps

**Q60.** Quelle est la différence entre `email.css`, `pdf.css` et `app.css` dans le projet ?
- A) `email.css` et `pdf.css` sont des fichiers de test
- B) `app.css` utilise Tailwind (classes utilitaires) pour le site. `email.css` et `pdf.css` utilisent du CSS classique car les clients email et les générateurs PDF ne supportent pas les classes Tailwind modernes
- C) `email.css` est pour les emails marketing, `pdf.css` pour les factures admin
- D) Il n'y a aucune différence technique

**Q61.** Pourquoi la librairie Dompdf utilise-t-elle `isRemoteEnabled: false` dans `FactureService` ?
- A) Pour accélérer la génération du PDF
- B) Pour des raisons de sécurité — autoriser les ressources distantes permettrait à un contenu malveillant d'effectuer des requêtes serveur depuis le générateur PDF (SSRF)
- C) Parce que Dompdf ne supporte pas les URLs distantes
- D) Pour réduire la taille du fichier PDF

**Q62.** Pourquoi le projet utilise-t-il `str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT)` pour générer la référence de commande ?
- A) Pour économiser des caractères
- B) Pour obtenir un numéro lisible formaté sur 5 chiffres (ex: `CMD-2026-00042`) avec un padding de zéros à gauche, plus agréable pour le client qu'un ID Doctrine brut
- C) C'est une exigence légale française
- D) Pour être compatible avec Stripe

**Q63.** Le panier est stocké en **session PHP** dans ce projet. Quels sont les avantages et inconvénients de ce choix par rapport à un stockage en base de données ?
- A) La session est plus sécurisée que la base de données
- B) **Avantage** : rapide, pas de requête SQL, fonctionne sans compte. **Inconvénient** : le panier est perdu si la session expire ou si l'utilisateur change de navigateur — impossible de retrouver un panier abandonné
- C) La session est la seule option dans Symfony
- D) La base de données serait trop lente pour le panier

---

**Corrections partie 8 :** 57-B / 58-B / 59-B / 60-B / 61-B / 62-B / 63-B

---

## PARTIE 9 — Docker & Déploiement

**Q64.** Sur quel port est accessible le site en développement avec Docker ?
- A) 80
- B) 3000
- C) 8080
- D) 8000

**Q65.** Quel service Docker s'occupe de l'installation des dépendances et de la migration de la base de données au premier démarrage ?
- A) `nginx`
- B) `php`
- C) `init`
- D) `assets`

**Q66.** Pourquoi le service `assets` recompile Tailwind toutes les 30 secondes en boucle plutôt que d'utiliser un watcher ?
- A) Pour économiser des ressources CPU
- B) Parce que le watcher de fichiers inotify n'est pas supporté de manière fiable sous Windows avec Docker Desktop
- C) Tailwind v4 ne supporte pas le watch mode
- D) AssetMapper l'interdit

**Q67.** Quelle commande doit être exécutée après chaque modification d'un fichier CSS ou Twig pour régénérer les styles Tailwind ?
- A) `npm run build`
- B) `php bin/console tailwind:build`
- C) `php bin/console assets:install`
- D) `symfony encore dev`

---

**Corrections partie 9 :** 64-C / 65-C / 66-B / 67-B

---

## PARTIE 10 — Questions ouvertes (oral)

Ces questions n'ont pas de réponse unique — elles visent à structurer ta réflexion à l'oral.

**Q68.** Explique le cycle de vie d'une commande dans SamyDessert, depuis l'ajout au panier jusqu'à la confirmation.

> Pistes : panier session → adresse → récapitulatif → Stripe Checkout → succes() → entité Commande → email

**Q69.** Qu'est-ce que l'Atomic Design et comment est-il structuré dans ce projet ?

> Pistes : atoms (Button, Input, Icon...) → molecules (InputField, DessertCard...) → organisms (Header, LoginForm, PanierLive...) → pages. Chaque composant = classe PHP + template Twig.

**Q70.** Comment fonctionne le système de favoris de bout en bout ?

> Pistes : bouton dans DessertCard → Stimulus `favori` → fetch POST → `FavoriController` → 401 si non connecté → JSON `{favori: bool}` → `activeValueChanged()` met à jour l'icône → `flash-tooltip` outlet si non connecté

**Q71.** Pourquoi avoir choisi Tailwind v4 avec des tokens sémantiques plutôt que des couleurs brutes ?

> Pistes : cohérence visuelle, changement de couleur global en 1 ligne, compréhensibilité (`bg-danger` vs `bg-red-600`), pas de couleurs arbitraires dans les templates

**Q72.** Quelles mesures de sécurité as-tu mises en place et pourquoi ?

> Pistes : hachage `auto`, UserChecker (compte non vérifié), token CSRF, `#[IsGranted]`, vérification appartenance commande, Stripe côté serveur, variables d'environnement, `random_bytes` pour les tokens

---

## Récapitulatif des scores

| Partie | Questions | Points possibles |
|--------|-----------|-----------------|
| HTML & Sémantique | Q1–Q8 | 8 |
| CSS & Tailwind v4 | Q9–Q17 | 9 |
| JavaScript & Stimulus | Q18–Q26 | 9 |
| PHP & Symfony | Q27–Q37 | 11 |
| Twig Components | Q38–Q45 | 8 |
| Sécurité | Q46–Q51 | 6 |
| Base de données | Q52–Q56 | 5 |
| Architecture | Q57–Q63 | 7 |
| Docker | Q64–Q67 | 4 |
| **Total QCM** | **Q1–Q67** | **67** |
| **Questions orales** | **Q68–Q72** | bonus |
