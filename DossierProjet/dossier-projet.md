# Samy Ben Hamida -- Projet SamyDessert

---

## Table des matieres

1. Presentation personnelle
   1.1 Qui suis-je et mon parcours
2. Presentation du projet SamyDessert
   2.1 Genese du projet et vision
   2.2 Objectifs du projet
3. Architecture technique
   3.1 Stack technologique
   3.2 Outils et services complementaires
4. Conception UX/UI
   4.1 Analyse et inspiration
   4.2 Personas utilisateurs
   4.3 User flow
   4.4 Choix visuels et accessibilite
   4.5 Identite visuelle
   4.6 Design system
   4.7 Wireframes et maquettes
5. Methodologie de conception
   5.1 Demarche de conception
   5.2 User stories
6. Conception de la base de donnees
7. Developpement front-end
   7.1 Approche Atomic Design
   7.2 Les atomes
   7.3 Les molecules
   7.4 Les organismes
8. Accessibilite
9. Securite
   9.1 Authentification et gestion des utilisateurs
   9.2 Inscription et verification d'e-mail
   9.3 Controle de l'etat du compte
   9.4 Protection des formulaires et des actions sensibles
   9.5 Securisation de l'espace client
   9.6 Paiement en ligne avec Stripe
   9.7 Gestion des secrets et configuration
   9.8 Limites actuelles et ameliorations possibles
10. Tests
11. Deploiement
12. Evolution du projet
13. Conclusion

---

## 1. Presentation personnelle

### 1.1 Qui suis-je et mon parcours

Je m'appelle Samy Ben Hamida, j'ai 34 ans. Apres l'obtention d'un baccalaureat scientifique, j'ai effectue une premiere annee d'etudes en informatique a l'universite Paris Descartes.

Je suis aujourd'hui en formation de developpeur web et web mobile a l'ESRP Auxilia, dans le cadre d'un parcours en alternance. Cette formation s'organise avec un rythme d'une semaine en centre et une semaine en stage.

J'effectue mon stage au sein de l'association Creative Handicap, qui a pour objectif de rendre l'art et les metiers du numerique accessibles a tous, notamment a travers des formations en design web.

Je suis une personne calme, motivee, avec un bon esprit d'equipe. J'apprecie les defis et je dispose d'une bonne capacite d'analyse et de logique.

---

## 2. Presentation du projet SamyDessert

### 2.1 Genese du projet et vision

Le projet SamyDessert est ne de ma passion pour les desserts faits maison. J'ai l'habitude de preparer des desserts que je partage avec mes collegues, ce qui m'a permis de constater un interet reel pour des recettes simples et accessibles.

J'ai identifie plusieurs problemes dans les plateformes existantes : certaines sont complexes, peu accessibles ou proposent des recettes couteuses et difficiles a reproduire. A l'inverse, les plateformes de commande ne permettent pas toujours de comprendre ou reproduire les recettes.

### 2.2 Objectifs du projet

SamyDessert a pour objectif de proposer une plateforme hybride. L'utilisateur peut soit consulter des recettes simples, economiques et faciles a realiser, soit commander directement des desserts pour une livraison rapide.

Une attention particuliere est portee a l'accessibilite du site afin de garantir une experience claire, fluide et comprehensible pour tous.

---

## 3. Architecture technique

### 3.1 Stack technologique

Le projet repose sur **Symfony** et **PHP** pour le back-end. Symfony offre une structure robuste et modulaire permettant de maintenir un code organise et evolutif.

**Twig** est utilise comme moteur de templating afin de separer la logique du rendu. **Tailwind CSS** permet de construire rapidement des interfaces responsives grace a une approche utilitaire moderne.

La base de donnees repose sur **MySQL**, permettant de structurer les donnees liees aux utilisateurs, produits, recettes et commandes.

**JavaScript** et **Stimulus** sont utilises pour ajouter des interactions cote client de maniere legere et structuree.

L'environnement de developpement est contenerise avec **Docker**, avec **Nginx** comme serveur web et **Adminer** pour la gestion de la base de donnees.

La gestion des assets front-end (JavaScript, CSS) repose sur **AssetMapper**, l'outil natif de Symfony qui remplace Webpack Encore. Il permet d'importer des modules JavaScript directement via les import maps du navigateur, sans etape de bundling. En environnement Docker avec Nginx, les assets doivent etre compiles manuellement apres chaque modification avec `php bin/console asset-map:compile`. De meme, les styles Tailwind doivent etre regeneres avec `php bin/console tailwind:build` apres chaque modification CSS ou Twig.

### 3.2 Outils et services complementaires

- **Stripe** est utilise pour gerer les paiements en ligne de maniere securisee.
- **DBDiagram** est utilise pour concevoir le schema de la base de donnees.
- **Mailtrap** permet de tester l'envoi d'emails en environnement de developpement.
- Des outils comme **Coolors**, **Adobe Color** et **Colorable** ont ete utilises pour definir et tester les palettes de couleurs.
- Un outil d'analyse d'accessibilite comme **BlooAI** est prevu pour tester le site une fois developpe.

---

## 4. Conception UX/UI avec Figma

### 4.1 Analyse et inspiration

Une phase d'analyse a ete realisee a partir de sites existants afin d'identifier les bonnes pratiques en matiere d'UX.

*[Capture d'ecran : inspiration]*

### 4.2 Personas utilisateurs

Des personas ont ete definis pour representer les differents types d'utilisateurs.

*[Capture d'ecran : personas]*

### 4.3 User flow

Un user flow a ete concu pour modeliser le parcours utilisateur.

*[Capture d'ecran : user flow]*

### 4.4 Choix visuels et accessibilite

Une palette de couleurs coherente a ete definie avec differentes teintes. La typographie **Luciole** a ete choisie pour ameliorer la lisibilite et l'accessibilite.

*[Capture d'ecran : palette de couleurs]*
*[Capture d'ecran : typographie]*

### 4.5 Identite visuelle

Le logo du projet a ete concu avec **Affinity Designer** en coherence avec la palette de couleurs.

*[Capture d'ecran : logo]*

### 4.6 Design system

Un mini design system a ete mis en place avec des composants reutilisables et des variables de couleurs.

*[Capture d'ecran : design system]*

### 4.7 Wireframes et maquettes

Les interfaces ont ete concues en mobile-first, puis adaptees tablette et desktop.

*[Capture d'ecran : mobile]*
*[Capture d'ecran : tablette]*
*[Capture d'ecran : desktop]*

---

## 5. Methodologie de conception

### 5.1 Demarche de conception

*(A completer)*

### 5.2 User stories

*(A completer)*

---

## 6. Conception de la base de donnees

*(A completer)*

---

## 7. Developpement front-end

### 7.1 Approche Atomic Design

Le front-end est base sur une approche **Atomic Design**. Les composants les plus simples (atomes) ont ete developpes en premier sous forme de composants Twig. Ces atomes incluent notamment : boutons, inputs, labels, liens, images et icones.

Chaque composant est concu pour etre reutilisable, coherent et accessible. **Tailwind CSS** est utilise pour le style, permettant une integration rapide et responsive.

### 7.2 Les atomes -- les plus petites briques de l'interface

#### Qu'est-ce qu'un atome ?

Pour construire l'interface de SamyDessert, je me suis base sur une methode de conception appelee **Atomic Design**, creee par Brad Frost. L'idee est simple : on commence par les elements les plus petits (les atomes), on les assemble pour former des blocs plus complexes (les molecules), et ainsi de suite jusqu'aux pages completes.

Un atome, c'est l'element le plus basique qu'on ne peut pas decouper davantage : un bouton, un champ de texte, une icone. Seul, il ne fait pas grand-chose. Mais une fois combine avec d'autres atomes, il permet de construire toute une interface.

Dans mon projet, j'ai implemente ces atomes en utilisant **Symfony UX Twig Components**. Concretement, chaque atome est compose de deux fichiers : une classe PHP qui definit ses options configurables, et un template Twig qui genere le HTML final.

#### Les atomes crees

J'ai developpe **14 atomes** au total, chacun correspondant a un element HTML precis :

| Atome        | Balise HTML                  | Role                                        |
|--------------|------------------------------|---------------------------------------------|
| Button       | `<button>`                   | Bouton d'action avec variantes de style     |
| ButtonIcon   | `<button>`                   | Bouton circulaire avec icone seule          |
| Input        | `<input>`                    | Champ de saisie (texte, email, mot de passe) |
| Textarea     | `<textarea>`                 | Zone de texte multiligne                    |
| Select       | `<select>`                   | Liste deroulante                            |
| Checkbox     | `<input type="checkbox">`    | Case a cocher                               |
| Label        | `<label>`                    | Libelle d'un champ de formulaire            |
| Link         | `<a>`                        | Lien hypertexte                             |
| Image        | `<img>`                      | Image avec chargement optimise              |
| Icon         | `<i>`                        | Icone Font Awesome                          |
| Badge        | `<span>`                     | Etiquette coloree (statut, categorie)       |
| Spinner      | `<svg>`                      | Animation de chargement                     |
| Card         | `<article>`                  | Conteneur de carte                          |
| PanierBadge  | `<span>`                     | Compteur du panier (mis a jour en temps reel) |

#### Conception des atomes

**Separer la logique du style**

Pour chaque atome, j'ai separe ce qui releve de la logique (gere en PHP) et ce qui releve du HTML pur (gere via les attributs Twig). Par exemple, pour le bouton, j'ai declare en PHP uniquement ce qui change son comportement : la variante visuelle, la taille, l'etat desactive. Tout le reste -- l'id, le name, les attributs data-* -- passe directement sans etre redeclare.

```php
final class Button {
    public string $variant  = 'primary'; // primary | secondary | ghost
    public string $size     = 'md';      // sm | md | lg
    public bool   $disabled = false;
    public bool   $loading  = false;
}
```

Grace a ca, les atomes restent simples et reutilisables dans n'importe quel contexte.

*[Capture d'ecran : les trois variantes du Button -- primary, secondary, ghost]*

**Des styles flexibles mais coherents**

Pour gerer les styles CSS, j'ai utilise une methode proposee par Symfony UX : `attributes.defaults()`. Elle permet de definir des styles par defaut sur chaque atome, tout en laissant la possibilite de les modifier depuis l'exterieur si besoin. Ainsi, tous les boutons ont le meme aspect de base, mais on peut adapter leur style selon le contexte sans toucher au composant.

**L'accessibilite, integree des le depart**

Des la conception des atomes, j'ai veille a respecter les bonnes pratiques d'accessibilite :

- **Navigation au clavier** : j'utilise `focus-visible:outline` plutot que `focus:outline`, ce qui affiche le contour uniquement lors de la navigation clavier, sans perturber l'experience souris.
- **Champs invalides** : le style d'erreur (bordure rouge) s'applique automatiquement via l'attribut `aria-invalid`, sans JavaScript.
- **Icones decoratives** : quand une icone est purement visuelle, je lui ajoute `aria-hidden="true"` pour qu'elle ne soit pas lue par les lecteurs d'ecran.
- **Spinner** : j'ai ajoute `role="status"` et `aria-live="polite"` pour que les technologies d'assistance annoncent le chargement en cours.

*[Capture d'ecran : focus visible sur un Input lors de la navigation clavier]*

**Les etats visuels des champs de formulaire**

Les champs Input, Textarea et Select partagent tous les memes etats visuels, definis uniquement en CSS :

| Etat         | Effet visuel                  |
|--------------|-------------------------------|
| Normal       | Fond creme, bordure grise     |
| En focus     | Contour framboise             |
| Invalide     | Bordure rouge                 |
| Lecture seule| Fond semi-transparent         |
| Desactive    | Fond gris, curseur bloque     |

*[Capture d'ecran : les cinq etats d'un Input -- normal, focus, invalide, readonly, disabled]*

#### Exemple concret : le Button

Le composant Button est un bon exemple de ce que j'ai voulu mettre en place sur l'ensemble du projet. Il propose trois variantes visuelles, trois tailles, et un etat de chargement. Quand loading est active, un spinner apparait automatiquement, le bouton se desactive, et l'attribut `aria-busy="true"` est ajoute pour informer les lecteurs d'ecran que l'action est en cours.

*[Capture d'ecran : Button en etat loading avec spinner]*

Ces 14 atomes forment le vocabulaire visuel de toute l'application. Chaque element d'interface que l'utilisateur voit ou avec lequel il interagit est construit a partir de l'un d'eux.

### 7.3 Les molecules -- assembler les atomes en blocs fonctionnels

#### Qu'est-ce qu'une molecule ?

Dans la logique Atomic Design, une molecule est un groupe d'atomes qui fonctionnent ensemble pour remplir une fonction precise. Par exemple, un champ de formulaire complet est une molecule : il combine un Label (atome), un Input (atome) et un message d'erreur pour former un bloc coherent et reutilisable.

Les molecules ne sont pas des pages ni des sections entières. Ce sont des blocs intermediaires suffisamment autonomes pour etre reutilises dans differents contextes, mais suffisamment simples pour rester faciles a comprendre et a maintenir.

#### Les molecules creees

J'ai developpe **18 molecules** au total :

| Molecule         | Atomes composes                    | Role                                                   |
|------------------|------------------------------------|---------------------------------------------------------|
| InputField       | Label + Input                      | Champ de saisie complet avec label, aide et erreur      |
| TextareaField    | Label + Textarea                   | Zone de texte complete avec label, aide et erreur        |
| SelectField      | Label + Select                     | Liste deroulante complete avec label, aide et erreur     |
| CheckboxField    | Checkbox + Label                   | Case a cocher avec label et message d'erreur             |
| RadioGroup       | Label + inputs radio               | Groupe de boutons radio avec legende et validation       |
| FormField        | Label + bloc generique             | Champ de formulaire generique (wrapper reutilisable)     |
| FormFieldGroup   | Fieldset + legende                 | Regroupement semantique de champs (fieldset ou group)    |
| FormActions      | Bloc d'actions                     | Zone d'actions en bas de formulaire (boutons)            |
| Alert            | Icon + texte                       | Message d'alerte contextuel (info, succes, erreur)       |
| DessertCard      | Image + Badge + Link + Icon        | Carte produit ou recette avec image, prix et actions     |
| BoutonPanier     | ButtonIcon + Icon + Spinner        | Bouton d'ajout au panier avec controle de quantite       |
| SearchBar        | Input + Button + Icon              | Barre de recherche avec champ et bouton                  |
| Nav              | Link                               | Liste de liens de navigation                             |
| NavigationLinks  | Link                               | Navigation principale avec detection de la page active   |
| FlashTooltip     | Texte + animation                  | Info-bulle temporaire (confirmation d'action)            |
| ConfirmDialog    | Button (confirmer + annuler)       | Boite de dialogue de confirmation                        |
| CookieBanner     | Link + Button                      | Bandeau de consentement cookies (RGPD)                   |
| CarouselCard     | Image + texte                      | Carte de carousel avec image et description              |

#### Conception des molecules

**Des champs de formulaire complets et accessibles**

Les molecules de formulaire (InputField, TextareaField, SelectField, CheckboxField, RadioGroup) suivent toutes le meme schema de conception. Chaque molecule assemble un Label et un champ de saisie, gere automatiquement les identifiants HTML pour lier le label au champ, et affiche un message d'aide ou d'erreur sous le champ lorsque c'est necessaire.

Un systeme de getters calcules en PHP genere les identifiants de maniere coherente. Par exemple, pour un champ dont l'identifiant est `email`, le message d'aide recoit automatiquement l'identifiant `email__help` et le message d'erreur `email__error`. Ces identifiants sont relies au champ via `aria-describedby`, ce qui permet aux lecteurs d'ecran de les associer correctement.

```php
public function getDescribedBy(): string
{
    $ids = [];
    if ($this->help)  $ids[] = $this->getHelpId();
    if ($this->error) $ids[] = $this->getErrorId();
    return implode(' ', $ids);
}
```

Lorsqu'une erreur est presente, le champ recoit automatiquement `aria-invalid="true"` et le message d'erreur est annonce aux technologies d'assistance grace a `role="alert"`. Cette logique est partagee par toutes les molecules de formulaire, ce qui garantit une experience coherente sur l'ensemble de l'application.

*[Capture d'ecran : InputField avec label, aide et message d'erreur]*

**La DessertCard : une molecule a double usage**

La molecule DessertCard est le composant central de l'affichage des produits et des recettes. Elle fonctionne en deux modes selon les donnees qu'elle recoit :

- **Mode produit** : affiche le prix, le bouton d'ajout au panier (BoutonPanier) et un lien vers la fiche produit.
- **Mode recette** : affiche la difficulte (via un Badge colore), le temps de preparation, le nombre de portions, la categorie et un lien vers la recette.

La carte integre egalement un systeme de favoris avec un bouton coeur qui declenche une animation de confirmation via le composant FlashTooltip. L'ensemble est pilote par un controleur Stimulus pour gerer les interactions cote client.

```php
public string $titre = '';
public ?string $prix = null;       // → mode produit
public string $difficulte = '';     // → mode recette
public ?int $produitId = null;      // → active le BoutonPanier
public bool $favori = false;        // → etat du favori
```

*[Capture d'ecran : DessertCard en mode produit et en mode recette cote a cote]*

**Le BoutonPanier : un Live Component reactif**

Le BoutonPanier est l'une des deux molecules implementees en tant que **Symfony UX Live Component**. Il permet d'ajouter un produit au panier et d'ajuster la quantite directement depuis la carte produit, sans rechargement de page.

Lorsque l'utilisateur clique sur "Ajouter au panier", le bouton se transforme en controleur de quantite avec des boutons plus et moins. La quantite est lue depuis le service de panier en session, ce qui garantit que l'affichage reste fiable meme apres un rechargement. A chaque modification, un evenement `panierUpdated` est emis pour mettre a jour le compteur du panier dans le header.

*[Capture d'ecran : BoutonPanier avant et apres ajout au panier]*

**Boites de dialogue et bandeaux**

La molecule ConfirmDialog utilise l'element HTML natif `<dialog>`, ce qui garantit une accessibilite native avec gestion du focus et du clavier. Elle propose des variantes de couleur pour le bouton de confirmation (danger, succes, primaire) et relie le titre et le message au dialogue via `aria-labelledby` et `aria-describedby`.

La molecule CookieBanner gere le consentement cookies conformement au RGPD. Elle utilise `role="alertdialog"` et un controleur Stimulus pour enregistrer le choix de l'utilisateur et masquer le bandeau.

*[Capture d'ecran : ConfirmDialog et CookieBanner]*

**Navigation intelligente**

La molecule NavigationLinks genere automatiquement les liens de navigation a partir de la route courante. Grace a la methode `mount()`, elle detecte la page active et applique `aria-current="page"` sur le lien correspondant, sans configuration manuelle.

```php
public function mount(): void
{
    $path = $this->requestStack->getCurrentRequest()?->getPathInfo() ?? '/';
    $this->links = [
        ['label' => 'Accueil',    'href' => '/',         'current' => $path === '/'],
        ['label' => 'Desserts',   'href' => '/produits',  'current' => str_starts_with($path, '/produits')],
        // ...
    ];
}
```

### 7.4 Les organismes -- les sections completes de l'interface

#### Qu'est-ce qu'un organisme ?

Un organisme est le niveau le plus eleve de composition avant la page elle-meme. Il regroupe plusieurs molecules et atomes pour former une section complete et autonome de l'interface : un header avec navigation, un formulaire de connexion complet, un panier interactif.

Dans SamyDessert, chaque organisme est egalement un Twig Component avec sa classe PHP et son template. Certains organismes sont des **Live Components** qui se mettent a jour en temps reel sans rechargement de page.

#### Les organismes crees

J'ai developpe **9 organismes** au total :

| Organisme        | Molecules / Atomes composes                              | Role                                            |
|------------------|-----------------------------------------------------------|-------------------------------------------------|
| Header           | NavigationLinks + Link + Image + Button + Icon            | En-tete du site avec navigation et menu mobile   |
| Footer           | Nav + Link + Icon                                        | Pied de page avec liens, mentions et reseaux     |
| Form             | Bloc generique (fieldset)                                | Formulaire de base reutilisable                  |
| LoginForm        | Form + Alert + InputField + CheckboxField + FormActions   | Formulaire de connexion complet                  |
| RegisterForm     | Form + Alert + InputField + FormActions                   | Formulaire d'inscription complet                 |
| AddressForm      | Form + Alert + InputField + SelectField + TextareaField + CheckboxField | Formulaire d'adresse de livraison   |
| PanierLive       | ButtonIcon + Icon                                        | Panier interactif en temps reel                  |
| ProductCardGrid  | DessertCard                                              | Grille responsive de cartes produits/recettes    |
| CartSummary      | Link                                                     | Recapitulatif du panier avec total et CTA        |

#### Conception des organismes

**Le Header : navigation responsive**

Le Header est un organisme sticky qui reste visible en haut de page lors du defilement. Il integre le logo, le nom de la marque et la navigation principale via la molecule NavigationLinks.

Sur desktop, la navigation s'affiche horizontalement. Sur mobile, un bouton hamburger ouvre un menu plein ecran via un element `<dialog>` natif. Le basculement entre les icones d'ouverture et de fermeture est gere par un controleur Stimulus `nav-toggle`. Le header expose egalement des blocs Twig (`actions` et `mobileActions`) qui permettent d'y injecter des elements supplementaires comme le compteur du panier ou le lien de connexion.

```twig
<header {{ attributes.defaults({ class: 'border-b bg-bg sticky top-0 z-50' }) }}>
```

*[Capture d'ecran : Header en version desktop et mobile]*

**Les formulaires : une architecture en couches**

Les formulaires de SamyDessert sont construits en trois couches :

1. **Form** : l'organisme de base qui genere la balise `<form>` avec les attributs d'accessibilite (`aria-label`, `aria-describedby`), la methode HTTP validee par un getter, et un `<fieldset>` optionnel pour desactiver tous les champs d'un coup.

2. **LoginForm, RegisterForm, AddressForm** : des organismes specialises qui composent Form avec les molecules de champs appropriees. Chacun gere ses propres messages d'erreur et expose un getter `getHasAnyError()` qui detecte automatiquement si au moins un champ est en erreur.

3. **Les molecules de champ** (InputField, SelectField, etc.) : chaque champ individuel avec son label, son aide et sa validation.

Tous les formulaires integrent un token CSRF sous forme de champ cache, une protection contre la double soumission via le controleur Stimulus `submit-once`, et un resume d'erreurs en haut du formulaire sous forme d'alerte accessible.

```php
// LoginForm.php
public function getHasAnyError(): bool
{
    return $this->emailError !== ''
        || $this->passwordError !== ''
        || $this->formError !== '';
}
```

Les champs de mot de passe utilisent `autocomplete="current-password"` pour la connexion et `autocomplete="new-password"` pour l'inscription, ce qui permet aux gestionnaires de mots de passe de fonctionner correctement. Le formulaire d'adresse utilise des attributs `autocomplete` specifiques (`given-name`, `family-name`, `address-line1`, `postal-code`) et `inputmode="numeric"` sur le code postal pour afficher un clavier numerique sur mobile.

*[Capture d'ecran : LoginForm avec erreurs affichees]*

**Le PanierLive : un panier en temps reel**

Le PanierLive est l'organisme le plus interactif du projet. Implemente en tant que **Symfony UX Live Component**, il ne recoit aucune prop : il s'alimente automatiquement depuis le service de panier stocke en session.

Il expose quatre actions live declenchees directement depuis le template :

- `ajouter(id)` : ajoute une unite d'un produit
- `retirer(id)` : retire une unite
- `supprimer(id)` : supprime completement un produit
- `vider()` : vide l'integralite du panier

Chaque action emet un evenement `panierUpdated` qui est capte par le composant PanierBadge dans le header, assurant ainsi la synchronisation en temps reel entre le panier et le compteur.

La zone des articles utilise `aria-live="polite"` pour que les technologies d'assistance annoncent les modifications du panier. Chaque bouton d'action dispose d'un `aria-label` contextualise avec le nom du produit.

*[Capture d'ecran : PanierLive avec articles et controles de quantite]*

**La ProductCardGrid : grille responsive**

La ProductCardGrid affiche une collection de DessertCard dans une grille responsive qui s'adapte automatiquement :

- **Mobile** : 1 colonne
- **Tablette** : 2 colonnes
- **Desktop** : 3 colonnes

```twig
<ul role="list" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
```

L'organisme est suffisamment flexible pour accepter aussi bien des produits que des recettes. Un systeme de mapping dans le template normalise les differentes structures de donnees (entites Doctrine ou tableaux) vers les props attendues par la DessertCard. La grille gere egalement l'etat des favoris en comparant les identifiants des produits avec la liste des favoris de l'utilisateur connecte.

*[Capture d'ecran : ProductCardGrid en version mobile, tablette et desktop]*

---

## 8. Accessibilite

L'accessibilite est integree des la conception du projet :

- **Typographie adaptee** : la police Luciole a ete choisie pour sa lisibilite optimale.
- **Contrastes verifies** : les combinaisons de couleurs respectent les ratios de contraste recommandes.
- **Navigation clavier** : tous les elements interactifs sont accessibles au clavier.
- **Attributs ARIA** : les attributs ARIA sont utilises pour enrichir la semantique des composants.
- **Structure HTML semantique** : les balises HTML appropriees sont utilisees pour structurer le contenu.

---

## 9. Securite

La securite est un aspect essentiel du projet SamyDessert. Plusieurs mecanismes ont ete mis en place afin de proteger les comptes utilisateurs, les donnees personnelles, les actions sensibles et le processus de commande.

### 9.1 Authentification et gestion des utilisateurs

La securite principale de l'application est configuree dans le fichier `security.yaml`. Cette configuration definit la maniere dont les utilisateurs sont authentifies, comment leurs mots de passe sont proteges, comment Symfony retrouve un utilisateur en base de donnees et quelles zones du site doivent etre securisees.

Les mots de passe des utilisateurs sont proteges grace au systeme de hachage de Symfony :

```yaml
password_hashers:
    Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
```

Cette configuration garantit que les mots de passe ne sont jamais stockes en clair dans la base de donnees. Symfony applique automatiquement un algorithme de hachage moderne et adapte, ce qui renforce la securite en cas de fuite de donnees.

Les utilisateurs sont charges depuis la base de donnees via l'entite Utilisateur, en utilisant l'adresse e-mail comme identifiant de connexion :

```yaml
providers:
    app_user_provider:
        entity:
            class: App\Entity\Utilisateur
            property: email
```

Le pare-feu principal de l'application est defini dans la section firewalls. Il gere la securite des utilisateurs connectes, utilise le fournisseur d'utilisateurs defini precedemment et s'appuie sur un UserChecker personnalise pour appliquer des regles metier supplementaires lors de l'authentification.

```yaml
firewalls:
    main:
        lazy: true
        provider: app_user_provider
        user_checker: App\Security\UserChecker
```

L'authentification se fait par formulaire, avec une route de connexion dediee et une redirection apres connexion reussie. La deconnexion est egalement prevue de maniere explicite, ce qui permet de fermer proprement la session utilisateur.

L'entite Utilisateur constitue elle aussi un element central de la securite. Elle implemente les interfaces `UserInterface` et `PasswordAuthenticatedUserInterface`, ce qui permet a Symfony de l'utiliser directement dans le systeme d'authentification. L'adresse e-mail est unique pour chaque compte, ce qui evite les doublons et permet une identification fiable. Les roles sont stockes sous forme de tableau JSON, avec l'ajout automatique de `ROLE_USER` pour tous les utilisateurs authentifies.

L'entite contient egalement un mecanisme de verification d'adresse e-mail avec les champs `isVerified` et `verificationToken`. Cela permet de distinguer les comptes actives des comptes encore en attente de confirmation.

### 9.2 Inscription et verification d'e-mail

Le controleur `SecurityController` gere la connexion, l'inscription et la confirmation d'adresse e-mail. Lors de l'inscription, plusieurs verifications sont effectuees : le mot de passe doit correspondre a sa confirmation, contenir au moins huit caracteres, et l'adresse e-mail ne doit pas deja exister dans la base de donnees.

Avant d'etre enregistre, le mot de passe est hache avec le composant de securite de Symfony :

```php
$user->setPassword($hasher->hashPassword($user, $password));
```

Un jeton de verification est ensuite genere de maniere securisee avec `random_bytes()` :

```php
$token = bin2hex(random_bytes(32));
```

Ce jeton est envoye a l'utilisateur dans un lien de confirmation genere en URL absolue. Lorsqu'il clique sur ce lien, l'application verifie que le jeton existe bien, active le compte, puis supprime le jeton afin qu'il ne puisse pas etre reutilise.

Cette logique permet de limiter les faux comptes et de s'assurer que l'adresse e-mail utilisee lors de l'inscription appartient reellement a l'utilisateur.

### 9.3 Controle de l'etat du compte

Le projet utilise egalement une classe `UserChecker` personnalisee. Celle-ci permet d'ajouter une regle metier de securite au moment de la connexion : un utilisateur ne peut pas se connecter tant que son compte n'a pas ete verifie par e-mail.

Si le compte n'est pas encore active, une exception controlee est levee et un message explicite est renvoye a l'utilisateur. Cette approche renforce la securite de l'authentification en ajoutant une condition supplementaire au-dela du simple mot de passe.

### 9.4 Protection des formulaires et des actions sensibles

Les formulaires de connexion et d'inscription integrent un token CSRF, ce qui permet de limiter les attaques de type falsification de requete intersite. Le formulaire de connexion utilise le jeton attendu par Symfony Security, tandis que le formulaire d'inscription inclut egalement un token cache.

Dans le cas de l'espace client, la protection CSRF est aussi appliquee lors de l'annulation d'une commande. Avant toute annulation, le controleur verifie que le token recu est valide. Cela empeche qu'une action sensible puisse etre declenchee par une requete externe non legitime.

Certaines actions dynamiques, comme l'ajout ou la suppression de favoris, verifient egalement que l'utilisateur est connecte, que les parametres recus sont valides et que les elements cibles existent bien en base de donnees. Cela permet de securiser les interactions AJAX de l'application.

### 9.5 Securisation de l'espace client

Le controleur `CompteController` est protege par l'attribut `#[IsGranted('ROLE_USER')]`, ce qui reserve l'acces a l'espace personnel aux seuls utilisateurs connectes.

Lors de l'affichage des commandes, l'application ne recupere que les commandes appartenant a l'utilisateur authentifie. Lors de l'annulation d'une commande, une verification supplementaire garantit que la commande ciblee appartient bien a l'utilisateur connecte. Cela evite qu'un client puisse agir sur les commandes d'un autre simplement en modifiant un identifiant dans l'URL.

Un controle metier est egalement applique sur l'etat de la commande : seules les commandes confirmees peuvent etre annulees. Cette regle protege l'integrite du processus de commande et evite les incoherences fonctionnelles.

### 9.6 Paiement en ligne avec Stripe

#### Tunnel de commande

Le processus de commande est organise en trois etapes successives, chacune geree par le `CommandeController`.

**Etape 1 — Saisie de l'adresse de livraison (`/commande/adresse`)**
L'utilisateur renseigne son adresse de livraison via un formulaire dedie. Les champs obligatoires (prenom, nom, adresse, code postal, ville) sont valides cote serveur. En cas d'erreur, le formulaire est reaffiche avec les messages correspondants. Une fois l'adresse valide, elle est stockee en session et l'utilisateur est redirige vers l'etape suivante. Si le panier est vide, une redirection automatique vers la page panier est effectuee.

**Etape 2 — Recapitulatif de commande (`/commande`)**
L'utilisateur consulte le detail de sa commande : les produits, les quantites, les prix unitaires et le total. L'adresse de livraison saisie precedemment est affichee avec la possibilite de la modifier. Un bouton de paiement securise permet de passer a l'etape suivante. Si la session ne contient pas encore d'adresse, l'utilisateur est automatiquement redirige vers l'etape 1.

**Etape 3 — Paiement via Stripe Checkout**
Un clic sur le bouton de paiement soumet le formulaire vers `/commande/paiement`. Le serveur cree une session Stripe Checkout avec les articles du panier et redirige l'utilisateur vers la page de paiement hebergee par Stripe. Deux issues sont possibles :

- **Succes** : Stripe redirige vers `/commande/succes`. La commande est enregistree en base de donnees, le panier est vide, un email de confirmation est envoye a l'utilisateur et une page de confirmation lui est affichee.
- **Annulation** : Stripe redirige vers `/commande/annulation`. Le panier est conserve et l'utilisateur peut reprendre sa commande.

Le paiement en ligne est gere via **Stripe**. Cette approche permet de ne pas faire transiter les donnees bancaires directement par l'application, ce qui limite fortement les risques lies au traitement des paiements.

La cle secrete Stripe est utilisee cote serveur uniquement, via les variables d'environnement. Le montant du paiement est reconstruit a partir des donnees du panier cote serveur, sans faire confiance a un montant transmis par le navigateur. Cette methode est plus sure et permet de conserver la coherence entre le panier, le compte utilisateur et la session de paiement.

Cependant, la creation finale de la commande confirmee repose actuellement sur l'arrivee de l'utilisateur sur la page de succes apres paiement. Cette approche reste fonctionnelle, mais elle pourrait etre renforcee. Dans une version plus robuste, il serait preferable de confirmer definitivement la commande a partir d'une verification serveur independante, par exemple via la recuperation securisee de la session Stripe ou l'utilisation d'un webhook Stripe.

### 9.7 Gestion des secrets et configuration

Le projet utilise les variables d'environnement pour stocker les informations sensibles telles que la connexion a la base de donnees, les acces SMTP ou les cles Stripe. Les secrets sont places dans `.env.local`, ce qui permet d'eviter leur diffusion dans le code source versionne.

Cette separation entre le code et la configuration constitue une bonne pratique importante. Elle permet d'adapter facilement l'application selon l'environnement de developpement ou de production, tout en limitant les risques de fuite d'informations sensibles.

En production, il serait preferable d'utiliser directement les variables d'environnement du serveur ou un systeme de gestion de secrets dedie. De plus, certaines configurations tolerables en developpement, comme l'utilisation du compte root pour la base de donnees, ne devraient pas etre conservees en production.

### 9.8 Limites actuelles et ameliorations possibles

La base de securite du projet est solide, mais plusieurs ameliorations peuvent encore etre envisagees :

- Utiliser davantage les formulaires Symfony avec validation integree
- Renforcer les contraintes sur les mots de passe
- Ajouter une expiration pour les jetons de verification
- Ameliorer la protection du formulaire de contact avec un token CSRF et un systeme anti-spam
- Fiabiliser le tunnel de paiement avec une confirmation serveur independante

---

## 10. Tests

*(A completer)*

---

## 11. Deploiement

*(A completer)*

---

## 12. Evolution du projet

*(A completer)*

---

## 13. Conclusion

Le projet SamyDessert est un projet e-commerce structure, combinant conception UX/UI, accessibilite et developpement moderne.

Il permet de proposer une experience utilisateur claire, en offrant a la fois la consultation de recettes et la commande de desserts.

Ce projet demontre ma capacite a concevoir, structurer et developper une application web complete en respectant les bonnes pratiques actuelles.
