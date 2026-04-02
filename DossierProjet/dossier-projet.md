# Samy Ben Hamida -- Projet SamyDessert

---

## Table des matieres

0. Introduction et contexte du projet
1. Presentation personnelle
   1.1 Qui suis-je et mon parcours
2. Presentation du projet SamyDessert
   2.1 Genese du projet et vision
   2.2 Objectifs du projet
   2.3 Nature du projet
   2.4 Back-office et administration
3. Cahier des charges et recueil du besoin
   3.1 Contexte et problematique
   3.2 Besoin principal
   3.3 Public cible
   3.4 Fonctionnalites principales
   3.5 Contraintes du projet
   3.6 Etude de faisabilite
4. Specifications fonctionnelles
   4.1 Fonctionnalites cote visiteur
   4.2 Fonctionnalites cote utilisateur connecte
   4.3 Fonctionnalites liees a la commande
   4.4 Fonctionnalites d'administration
5. Architecture technique
   5.1 Stack technologique
   5.2 Outils et services complementaires
6. Conception UX/UI
   6.1 Analyse et inspiration
   6.2 Personas utilisateurs
   6.3 User flow
   6.4 Choix visuels et accessibilite
   6.5 Identite visuelle
   6.6 Design system
   6.7 Wireframes et maquettes
7. Methodologie de conception
   7.1 Demarche de conception
   7.2 User stories
8. Conception de la base de donnees
9. Developpement front-end
   9.1 Approche Atomic Design
   9.2 Les atomes
   9.3 Les molecules
   9.4 Les organismes
   9.5 Les controllers Stimulus
   9.6 Architecture CSS -- Tailwind v4 et design tokens
   9.7 Developpement back-end -- controllers et services
   9.8 Le reste de src/
10. Accessibilite
11. Securite
    11.1 Authentification et gestion des utilisateurs
    11.2 Inscription et verification d'e-mail
    11.3 Controle de l'etat du compte
    11.4 Protection des formulaires et des actions sensibles
    11.5 Securisation de l'espace client
    11.6 Paiement en ligne avec Stripe
    11.7 Gestion des secrets et configuration
    11.8 Limites actuelles et ameliorations possibles
12. Tests
13. Deploiement
14. Evolution du projet
15. Bilan personnel
16. Conclusion
Annexe A -- Schema de la base de donnees
Annexe B -- Schema de fonctionnement de l'application
Annexe C -- Bug OOM BlockStack (exemple de debogage)

---

## 0. Introduction et contexte du projet

Dans le cadre de ma formation de developpeur web et web mobile a l'ESRP Auxilia de Nanterre, j'ai realise le projet SamyDessert comme projet de fin de formation, destine a etre presente devant un jury.

Ce projet a ete commence au debut du mois de novembre 2025 et s'inscrit dans une demarche professionnalisante visant a mettre en pratique l'ensemble des competences acquises durant la formation, aussi bien en conception qu'en developpement.

SamyDessert est un projet individuel, realise avec l'accompagnement de mon formateur à Auxilia : Stéphane ASSABY ainsi que de mes deux tuteurs de stage : Miguel Sevilla et Jean-Baptiste Guérin au sein de l'association Creative Handicap. Ces echanges m'ont permis d'apprendre avec des proffesionnels, de prendre du recul sur mes choix techniques, de mieux comprendre les attentes du metier et d'ameliorer la qualite globale du projet.

Le projet s'appuie egalement sur l'utilisation d'outils modernes, dont certains outils d'intelligence artificielle utilises comme support d'apprentissage, de recherche et d'optimisation. Ces outils ont ete utilises de maniere complementaire a la documentation officielle et aux ressources techniques.

SamyDessert est un projet fictif, mais concu pour repondre a un besoin reel. Il s'agit d'une plateforme e-commerce hybride combinant deux approches : proposer des recettes de desserts gratuites afin d'attirer les utilisateurs, et permettre la commande de gateaux faits maison par un artisan patissier, simples et accessibles.

Ce projet a pour objectif de demontrer ma capacite a concevoir, structurer et developper une application web complete, en prenant en compte les enjeux actuels du web tels que l'accessibilite, l'experience utilisateur, la performance et la maintenabilite du code.

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

### 2.3 Nature du projet

Le projet SamyDessert est un projet de fin de formation a visee professionnelle. Il s'agit d'un projet fictif, mais concu pour repondre a un besoin reel.

Le site repose sur un concept hybride : proposer des recettes de cuisine gratuites afin d'attirer les utilisateurs, tout en offrant la possibilite de commander des gateaux faits maison, simples et accessibles.

Cette approche permet de creer une valeur ajoutee en combinant contenu gratuit (recettes) et offre commerciale (vente de desserts), dans une logique proche de certains modeles existants sur le web.

### 2.4 Back-office et administration

Le projet integre une interface d'administration permettant de gerer les commandes, les utilisateurs, les produits et les recettes.

Cette partie a pour objectif de faciliter la gestion du site au quotidien, aussi bien pour le suivi des commandes que pour la mise a jour du catalogue et du contenu. Elle est realisee avec **EasyAdmin**, qui permet de mettre en place rapidement une interface robuste avec Symfony.

L'administration comprend :
- La gestion des produits (ajout, modification avec upload d'image, suppression)
- La gestion des recettes avec editeur de contenu
- Le suivi des commandes avec changement de statut
- La gestion des comptes utilisateurs
- Un calendrier des commandes (en cours de developpement)

---

## 3. Cahier des charges et recueil du besoin

### 3.1 Contexte et problematique

Le projet SamyDessert s'inscrit dans le domaine du e-commerce alimentaire, avec une approche centree sur les desserts faits maison. Lors de l'analyse des sites existants, plusieurs problemes ont ete identifies : certaines plateformes sont complexes a utiliser, peu accessibles ou proposent des recettes difficiles a reproduire et couteuses.

De plus, les sites de vente de desserts ne permettent generalement pas de comprendre comment les produits sont realises, ce qui limite l'interet pedagogique pour l'utilisateur.

### 3.2 Besoin principal

Le besoin principal est de concevoir une plateforme simple, accessible et claire, permettant a la fois :

- de consulter des recettes de desserts faciles a realiser
- de commander des desserts faits maison
- de proposer une experience utilisateur fluide et comprehensible par tous

Le projet vise donc a combiner une dimension pedagogique (recettes) et une dimension commerciale (vente de desserts).

### 3.3 Public cible

Le site s'adresse principalement a :

- des particuliers souhaitant commander des desserts pour un usage personnel ou evenementiel
- des personnes interessees par la cuisine maison et les recettes simples
- des utilisateurs recherchant une interface accessible et facile a utiliser

### 3.4 Fonctionnalites principales

Les fonctionnalites du projet ont ete definies a partir des besoins utilisateurs.

Cote visiteur :
- consulter le catalogue de desserts
- consulter les recettes
- rechercher et filtrer des produits ou recettes
- s'inscrire et creer un compte
- contacter le site via un formulaire

Cote utilisateur connecte :
- ajouter des produits au panier
- passer une commande en ligne
- renseigner une adresse de livraison
- consulter l'historique des commandes
- annuler une commande sous conditions
- ajouter des produits en favoris

Cote administration :
- gerer les produits (ajout, modification, suppression, upload d'image)
- gerer les recettes
- gerer les commandes
- gerer les utilisateurs

### 3.5 Contraintes du projet

Le projet doit respecter plusieurs contraintes :

- utilisation de technologies modernes (Symfony, Twig, Tailwind, Docker)
- respect des bonnes pratiques de securite
- prise en compte de l'accessibilite (contrastes, navigation clavier, structure HTML)
- conception responsive (mobile, tablette, desktop)
- structuration du code pour garantir sa maintenabilite et son evolutivite

### 3.6 Etude de faisabilite

**Faisabilite technique**

Le projet repose sur des technologies maitrisees dans le cadre de la formation, notamment Symfony, Twig, Tailwind CSS et MySQL. Ces outils offrent un cadre robuste et adapte pour la creation d'une application e-commerce.

L'utilisation de Docker permet de standardiser l'environnement de developpement et de faciliter la mise en place du projet. Les outils complementaires comme Stripe pour le paiement ou Mailtrap pour les emails sont egalement bien documentes et integrables facilement.

Ainsi, l'ensemble des technologies choisies est coherent avec les objectifs du projet et realisable dans le cadre de la formation.

**Faisabilite temporelle**

Le projet a ete realise sur une periode debutant en decembre, dans le cadre d'un rythme altere entre formation et stage.

Le temps disponible a permis de developper les fonctionnalites principales : catalogue, recettes, panier, commande, authentification et interface utilisateur. Certaines fonctionnalites plus avancees (avis, contribution utilisateur, marketplace) ont ete identifiees mais planifiees comme evolutions futures.

**Faisabilite fonctionnelle**

Le projet correspond a un modele e-commerce classique enrichi d'une dimension de contenu (recettes), ce qui reste coherent et realisable.

Les fonctionnalites principales ont ete priorisees afin de garantir un produit fonctionnel et stable, tout en gardant une architecture suffisamment flexible pour permettre des evolutions futures.

---

## 4. Specifications fonctionnelles

### 4.1 Fonctionnalites cote visiteur (non connecte)

Le visiteur peut acceder librement au contenu du site sans authentification.

Il peut :
- consulter la page d'accueil avec les produits mis en avant
- naviguer dans le catalogue de desserts
- consulter les fiches produits
- consulter les recettes de cuisine
- effectuer une recherche par mot-cle
- filtrer les contenus par categorie
- acceder au formulaire de contact
- creer un compte utilisateur

### 4.2 Fonctionnalites cote utilisateur connecte

Une fois connecte, l'utilisateur dispose de fonctionnalites supplementaires liees a son compte.

Il peut :
- ajouter des produits au panier
- modifier les quantites ou supprimer des produits du panier
- consulter le contenu du panier en temps reel
- renseigner une adresse de livraison
- passer une commande via Stripe
- consulter l'historique de ses commandes
- annuler une commande sous conditions
- ajouter ou retirer des produits de ses favoris
- acceder a son espace personnel

### 4.3 Fonctionnalites liees a la commande

Le processus de commande est structure en plusieurs etapes :
- saisie de l'adresse de livraison
- affichage du recapitulatif de la commande
- redirection vers le paiement securise via Stripe
- confirmation de la commande apres paiement

Le systeme garantit la coherence des donnees en recalculant le total cote serveur et en securisant les echanges avec Stripe.

### 4.4 Fonctionnalites d'administration

Une interface d'administration est prevue pour gerer le site.

Elle permet de :
- gerer les produits (ajout, modification avec upload d'image, suppression)
- gerer les recettes (contenu, image, categorie, difficulte)
- consulter et gerer les commandes (changement de statut : En attente, Confirmee, Livree, Annulee)
- gerer les comptes utilisateurs
- visualiser le calendrier des commandes (en cours de developpement)

---

## 5. Architecture technique

### 5.1 Stack technologique

Le projet repose sur **Symfony** et **PHP** pour le back-end. Symfony offre une structure robuste et modulaire permettant de maintenir un code organise et evolutif.

**Twig** est utilise comme moteur de templating afin de separer la logique du rendu. **Tailwind CSS** permet de construire rapidement des interfaces responsives grace a une approche utilitaire moderne.

La base de donnees repose sur **MySQL**, permettant de structurer les donnees liees aux utilisateurs, produits, recettes et commandes.

**JavaScript** et **Stimulus** sont utilises pour ajouter des interactions cote client de maniere legere et structuree.

L'environnement de developpement est contenerise avec **Docker**, avec **Nginx** comme serveur web et **Adminer** pour la gestion de la base de donnees.

La gestion des assets front-end (JavaScript, CSS) repose sur **AssetMapper**, l'outil natif de Symfony qui remplace Webpack Encore. Il permet d'importer des modules JavaScript directement via les import maps du navigateur, sans etape de bundling. En environnement Docker avec Nginx, les assets doivent etre compiles manuellement apres chaque modification avec `php bin/console asset-map:compile`. De meme, les styles Tailwind doivent etre regeneres avec `php bin/console tailwind:build` apres chaque modification CSS ou Twig.

### 5.2 Outils et services complementaires

- **Stripe** est utilise pour gerer les paiements en ligne de maniere securisee.
- **VichUploaderBundle** gere l'upload et le stockage des images produits et recettes.
- **DBDiagram** est utilise pour concevoir le schema de la base de donnees.
- **Mailtrap** permet de tester l'envoi d'emails en environnement de developpement.
- Des outils comme **Coolors**, **Adobe Color** et **Colorable** ont ete utilises pour definir et tester les palettes de couleurs.
- Un outil d'analyse d'accessibilite comme **BlooAI** est prevu pour tester le site une fois developpe.
- **Unsplash** est utilise comme source d'images libres de droits pour les produits et les recettes (photos de patisseries en haute resolution, licence Unsplash gratuite pour usage commercial).

---

## 6. Conception UX/UI avec Figma

### 6.1 Analyse et inspiration

Une phase d'analyse a ete realisee a partir de sites existants afin d'identifier les bonnes pratiques en matiere d'UX.

![Analyse et inspiration](captures/Inspiration.png)

### 6.2 Personas utilisateurs

Des personas ont ete definis pour representer les differents types d'utilisateurs.

![Persona 1](captures/personna1.png)
![Persona 2](captures/personna2.png)

### 6.3 User flow

Un user flow a ete concu pour modeliser le parcours utilisateur.

![User Flow](captures/userFlow.png)

### 6.4 Choix visuels et accessibilite

Une palette de couleurs coherente a ete definie avec differentes teintes. La typographie **Luciole** a ete choisie pour ameliorer la lisibilite et l'accessibilite.

*[Capture : palette de couleurs]*
*[Capture : typographie]*

### 6.5 Identite visuelle

Le logo du projet a ete concu avec **Affinity Designer** en coherence avec la palette de couleurs.

*[Capture : logo]*

### 6.6 Design system

Un mini design system a ete mis en place avec des composants reutilisables et des variables de couleurs.

*[Capture : design system]*

### 6.7 Wireframes et maquettes

Les interfaces ont ete concues en mobile-first, puis adaptees tablette et desktop.

![Wireframe basse fidelite](captures/wireframeLow.png)

*[Capture : maquette tablette]*
*[Capture : maquette desktop]*

---

## 7. Methodologie de conception

### 7.1 Demarche de conception

La conception du projet SamyDessert a suivi une demarche iterative, partant des besoins utilisateurs pour aboutir a l'implementation technique.

La premiere etape a ete d'identifier les utilisateurs cibles et leurs besoins a travers la definition de personas. Cette analyse a permis de definir les grandes fonctionnalites a developper et de prioriser le travail.

La conception UX/UI a ensuite ete realisee dans Figma, en suivant une approche mobile-first. Les maquettes ont ete concues pour trois breakpoints : mobile, tablette et desktop. Un design system a ete constitue en parallele, rassemblant les tokens de couleurs, la typographie et les composants reutilisables.

Le developpement a demarre par la mise en place de l'architecture technique (Symfony, Docker, base de donnees), puis par la construction des composants front-end selon la methode Atomic Design : d'abord les atomes, puis les molecules, puis les organismes, et enfin les pages completes.

### 7.2 User stories

Les principales fonctionnalites ont ete definies sous forme de user stories :

**Visiteur non connecte**
- En tant que visiteur, je veux consulter le catalogue de desserts pour decouvrir les produits disponibles.
- En tant que visiteur, je veux consulter les recettes pour apprendre a realiser des desserts chez moi.
- En tant que visiteur, je veux m'inscrire pour creer un compte et passer des commandes.
- En tant que visiteur, je veux contacter le site via un formulaire pour poser des questions.

**Utilisateur connecte**
- En tant qu'utilisateur connecte, je veux ajouter des produits au panier pour preparer ma commande.
- En tant qu'utilisateur connecte, je veux passer une commande en renseignant mon adresse et en payant en ligne.
- En tant qu'utilisateur connecte, je veux consulter l'historique de mes commandes pour suivre mes achats.
- En tant qu'utilisateur connecte, je veux annuler une commande confirmee si elle n'a pas encore ete traitee.
- En tant qu'utilisateur connecte, je veux ajouter des produits en favoris pour les retrouver facilement.

**Administrateur**
- En tant qu'administrateur, je veux gerer le catalogue de produits (ajout, modification, suppression).
- En tant qu'administrateur, je veux consulter et gerer les commandes passees par les clients.
- En tant qu'administrateur, je veux gerer les comptes utilisateurs.

---

## 8. Conception de la base de donnees

La base de donnees repose sur **MySQL** et est geree via **Doctrine ORM**. Elle contient sept entites principales.

### Les entites

**Utilisateur**
Represente un compte client. Stocke l'email (identifiant unique), le mot de passe hache, les informations personnelles (nom, prenom, telephone, adresse) et les roles Symfony. Deux champs specifiques gerent la verification d'email : `isVerified` (booleen) et `verificationToken` (token a usage unique supprime apres validation). Un utilisateur peut avoir plusieurs commandes et plusieurs produits en favoris.

**Produit**
Represente un dessert vendu sur le site. Contient le nom, la description, le prix (stocke en DECIMAL pour eviter les erreurs d'arrondi), le nom du fichier image (gere par VichUploaderBundle), un indicateur de disponibilite, un slug SEO-friendly et la date d'ajout. Un produit appartient a une categorie et peut etre associe a une recette.

**Categorie**
Regroupe les produits et les recettes par type (ex : Tartes, Choux, Petits fours). Possede un nom et un slug unique.

**Recette**
Represente une recette publiee sur le site. Contient le titre, la description, le contenu complet, le nom du fichier image, la duree en minutes, le niveau de difficulte (via un enum PHP), le nombre de portions et un slug. Une recette peut etre liee a un produit.

**Commande**
Represente une commande passee par un utilisateur. Contient la date, le statut (via un enum PHP : `EnAttente`, `Confirmee`, `Livree`, `Annulee`), le total, l'adresse de livraison et une reference lisible (ex : `CMD-2026-00042`). Une commande est liee a un utilisateur et contient plusieurs lignes de commande.

**CommandeProduit**
Table de jointure entre `Commande` et `Produit`. Constitue la ligne de commande : elle stocke la quantite et le **prix unitaire au moment de la commande** (snapshot), independamment du prix actuel du produit. La cle primaire est composite (commande + produit).

**Avis**
Represente un avis laisse par un utilisateur sur un produit. Contient une note et un commentaire. (entite preparee, non encore integree dans l'interface)

### Relations

```
Utilisateur  ──< Commande        (1 utilisateur → plusieurs commandes)
Commande     ──< CommandeProduit (1 commande → plusieurs lignes)
Produit      ──< CommandeProduit (1 produit → plusieurs lignes de commande)
Categorie    ──< Produit         (1 categorie → plusieurs produits)
Categorie    ──< Recette         (1 categorie → plusieurs recettes)
Produit      ──1 Recette         (1 produit → une recette liee, optionnelle)
Utilisateur  >──< Produit        (favoris — relation ManyToMany)
```

### Choix techniques notables

Le prix est stocke en `DECIMAL(8,2)` plutot qu'en `FLOAT` pour eviter les erreurs d'arrondi sur les calculs financiers. Le prix unitaire est duplique dans `CommandeProduit` pour conserver un historique fiable, independamment des modifications futures du catalogue. Les enums PHP natifs (`StatutCommande`, `Difficulte`) sont utilises pour les colonnes a valeurs controlees, ce qui garantit l'integrite des donnees au niveau du code.

Les images produits et recettes sont gerees par **VichUploaderBundle** : le fichier physique est stocke dans `public/uploads/produits/` ou `public/uploads/recettes/`, et seul le nom du fichier est enregistre en base de donnees. Cette approche evite de stocker des donnees binaires en base.

#### Ajout des images en pratique

Les images du catalogue ont ete preparees manuellement puis integrees de deux facons selon le contexte :

**Via l'interface d'administration (EasyAdmin)** : pour chaque produit ou recette, un champ upload est disponible dans le formulaire d'edition. L'administrateur selectionne une image depuis son poste, VichUploaderBundle la renomme automatiquement (via `SmartUniqueNamer`) pour eviter les conflits, et la depose dans le bon dossier (`public/uploads/produits/` ou `public/uploads/recettes/`). Seul le nom du fichier resultant est enregistre en base.

**Via les fixtures de developpement** : les images preparees (photos libres de droits provenant d'**Unsplash**, au format JPG, PNG ou WebP) ont ete deposees directement dans `public/uploads/produits/` et `public/uploads/recettes/`, puis leur nom de fichier a ete renseigne dans les fixtures PHP (`AppFixtures`). Cette methode permet de charger rapidement un jeu de donnees complet avec des visuels realistes sans passer par l'interface d'administration.

Dans les deux cas, le template Twig utilise la fonction `vich_uploader_asset(produit, 'imageFile')` pour generer l'URL publique de l'image a partir du nom de fichier stocke en base.

---

## 9. Developpement front-end

### 9.1 Approche Atomic Design

Le front-end est base sur une approche **Atomic Design**. Les composants les plus simples (atomes) ont ete developpes en premier sous forme de composants Twig. Ces atomes incluent notamment : boutons, inputs, labels, liens, images et icones.

Chaque composant est concu pour etre reutilisable, coherent et accessible. **Tailwind CSS** est utilise pour le style, permettant une integration rapide et responsive.

### 9.2 Les atomes -- les plus petites briques de l'interface

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
    public string $variant  = 'primary'; // primary | secondary | ghost | danger
    public string $size     = 'md';      // sm | md | lg
    public bool   $disabled = false;
    public bool   $loading  = false;
}
```

Grace a ca, les atomes restent simples et reutilisables dans n'importe quel contexte.

*[Capture : les variantes du Button -- primary, secondary, ghost, danger]*

**Des styles flexibles mais coherents**

Pour gerer les styles CSS, j'ai utilise une methode proposee par Symfony UX : `attributes.defaults()`. Elle permet de definir des styles par defaut sur chaque atome, tout en laissant la possibilite de les modifier depuis l'exterieur si besoin. Ainsi, tous les boutons ont le meme aspect de base, mais on peut adapter leur style selon le contexte sans toucher au composant.

**L'accessibilite, integree des le depart**

Des la conception des atomes, j'ai veille a respecter les bonnes pratiques d'accessibilite :

- **Navigation au clavier** : j'utilise `focus-visible:outline` plutot que `focus:outline`, ce qui affiche le contour uniquement lors de la navigation clavier, sans perturber l'experience souris.
- **Champs invalides** : le style d'erreur (bordure rouge) s'applique automatiquement via l'attribut `aria-invalid`, sans JavaScript.
- **Icones decoratives** : quand une icone est purement visuelle, je lui ajoute `aria-hidden="true"` pour qu'elle ne soit pas lue par les lecteurs d'ecran.
- **Spinner** : j'ai ajoute `role="status"` et `aria-live="polite"` pour que les technologies d'assistance annoncent le chargement en cours.

*[Capture : focus visible sur un Input lors de la navigation clavier]*

**Les etats visuels des champs de formulaire**

Les champs Input, Textarea et Select partagent tous les memes etats visuels, definis uniquement en CSS :

| Etat         | Effet visuel                  |
|--------------|-------------------------------|
| Normal       | Fond creme, bordure grise     |
| En focus     | Contour framboise             |
| Invalide     | Bordure rouge                 |
| Lecture seule| Fond semi-transparent         |
| Desactive    | Fond gris, curseur bloque     |

*[Capture : les cinq etats d'un Input]*

#### Exemple concret : le Button

Le composant Button est un bon exemple de ce que j'ai voulu mettre en place sur l'ensemble du projet. Il propose quatre variantes visuelles, trois tailles, et un etat de chargement. Quand loading est active, un spinner apparait automatiquement, le bouton se desactive, et l'attribut `aria-busy="true"` est ajoute pour informer les lecteurs d'ecran que l'action est en cours.

*[Capture : Button en etat loading avec spinner]*

Ces 14 atomes forment le vocabulaire visuel de toute l'application. Chaque element d'interface que l'utilisateur voit ou avec lequel il interagit est construit a partir de l'un d'eux.

### 9.3 Les molecules -- assembler les atomes en blocs fonctionnels

#### Qu'est-ce qu'une molecule ?

Dans la logique Atomic Design, une molecule est un groupe d'atomes qui fonctionnent ensemble pour remplir une fonction precise. Par exemple, un champ de formulaire complet est une molecule : il combine un Label (atome), un Input (atome) et un message d'erreur pour former un bloc coherent et reutilisable.

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
| FormFieldGroup   | Fieldset + legende                 | Regroupement semantique de champs                        |
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

Lorsqu'une erreur est presente, le champ recoit automatiquement `aria-invalid="true"` et le message d'erreur est annonce aux technologies d'assistance grace a `role="alert"`.

*[Capture : InputField avec label, aide et message d'erreur]*

**La DessertCard : une molecule a double usage**

La molecule DessertCard est le composant central de l'affichage des produits et des recettes. Elle fonctionne en deux modes selon les donnees qu'elle recoit :

- **Mode produit** : affiche le prix, le bouton d'ajout au panier (BoutonPanier) et un lien vers la fiche produit.
- **Mode recette** : affiche la difficulte (via un Badge colore), le temps de preparation, le nombre de portions, la categorie et un lien vers la recette.

La carte integre egalement un systeme de favoris avec un bouton coeur qui declenche une animation de confirmation via le composant FlashTooltip.

```php
public string $titre = '';
public ?string $prix = null;       // → mode produit
public string $difficulte = '';     // → mode recette
public ?int $produitId = null;      // → active le BoutonPanier
public bool $favori = false;        // → etat du favori
```

*[Capture : DessertCard en mode produit et en mode recette]*

**Le BoutonPanier : un Live Component reactif**

Le BoutonPanier est l'une des deux molecules implementees en tant que **Symfony UX Live Component**. Il permet d'ajouter un produit au panier et d'ajuster la quantite directement depuis la carte produit, sans rechargement de page.

Lorsque l'utilisateur clique sur "Ajouter au panier", le bouton se transforme en controleur de quantite avec des boutons plus et moins. La quantite est lue depuis le service de panier en session, ce qui garantit que l'affichage reste fiable meme apres un rechargement. A chaque modification, un evenement `panierUpdated` est emis pour mettre a jour le compteur du panier dans le header.

*[Capture : BoutonPanier avant et apres ajout au panier]*

**Boites de dialogue et bandeaux**

La molecule ConfirmDialog utilise l'element HTML natif `<dialog>`, ce qui garantit une accessibilite native avec gestion du focus et du clavier. La molecule CookieBanner gere le consentement cookies conformement au RGPD avec `role="alertdialog"`.

*[Capture : ConfirmDialog et CookieBanner]*

**Navigation intelligente**

La molecule NavigationLinks genere automatiquement les liens de navigation a partir de la route courante. Grace a la methode `mount()`, elle detecte la page active et applique `aria-current="page"` sur le lien correspondant, sans configuration manuelle.

### 9.4 Les organismes -- les sections completes de l'interface

#### Qu'est-ce qu'un organisme ?

Un organisme est le niveau le plus eleve de composition avant la page elle-meme. Il regroupe plusieurs molecules et atomes pour former une section complete et autonome de l'interface.

#### Les organismes crees

J'ai developpe **9 organismes** au total :

| Organisme        | Role                                            |
|------------------|-------------------------------------------------|
| Header           | En-tete du site avec navigation et menu mobile   |
| Footer           | Pied de page avec liens, mentions et reseaux     |
| Form             | Formulaire de base reutilisable                  |
| LoginForm        | Formulaire de connexion complet                  |
| RegisterForm     | Formulaire d'inscription complet                 |
| AddressForm      | Formulaire d'adresse de livraison                |
| PanierLive       | Panier interactif en temps reel                  |
| ProductCardGrid  | Grille responsive de cartes produits/recettes    |
| CartSummary      | Recapitulatif du panier avec total et CTA        |

#### Conception des organismes

**Le Header : navigation responsive**

Le Header est un organisme sticky qui reste visible en haut de page lors du defilement. Sur mobile, un bouton hamburger ouvre un menu plein ecran via un element `<dialog>` natif. Le basculement est gere par un controleur Stimulus `nav-toggle`.

*[Capture : Header en version desktop et mobile]*

**Les formulaires : une architecture en couches**

Les formulaires de SamyDessert sont construits en trois couches :

1. **Form** : l'organisme de base qui genere la balise `<form>` avec les attributs d'accessibilite, la methode HTTP validee, et un `<fieldset>` optionnel.
2. **LoginForm, RegisterForm, AddressForm** : des organismes specialises qui composent Form avec les molecules de champs appropriees.
3. **Les molecules de champ** : chaque champ individuel avec son label, son aide et sa validation.

Tous les formulaires integrent un token CSRF, une protection contre la double soumission via le controleur Stimulus `submit-once`, et un resume d'erreurs en haut du formulaire.

*[Capture : LoginForm avec erreurs affichees]*

**Le PanierLive : un panier en temps reel**

Le PanierLive est l'organisme le plus interactif du projet. Implemente en tant que **Symfony UX Live Component**, il s'alimente automatiquement depuis le service de panier stocke en session. Il expose quatre actions live : `ajouter`, `retirer`, `supprimer`, `vider`. Chaque action emet un evenement `panierUpdated` pour synchroniser le compteur dans le header.

*[Capture : PanierLive avec articles et controles de quantite]*

**La ProductCardGrid : grille responsive**

La ProductCardGrid affiche une collection de DessertCard dans une grille responsive (1 colonne mobile, 2 tablette, 3 desktop). Elle accepte aussi bien des produits que des recettes grace a un systeme de mapping dans le template.

*[Capture : ProductCardGrid en version mobile, tablette et desktop]*

### 9.5 Les controllers Stimulus -- interactions cote client

#### Qu'est-ce que Stimulus ?

Stimulus est un framework JavaScript leger developpe par l'equipe de Basecamp. Contrairement a React ou Vue, il ne prend pas en charge le rendu HTML : il se contente d'ajouter du comportement a un HTML deja present dans la page. Chaque controller est associe a un element HTML via l'attribut `data-controller`.

Dans SamyDessert, Stimulus est initialise via `stimulus_bootstrap.js`, qui enregistre manuellement chaque controller aupres de l'application.

#### Les controllers crees

J'ai developpe **10 controllers** au total :

| Controller           | Role                                                                 |
|----------------------|----------------------------------------------------------------------|
| `annulation`         | Boite de dialogue de confirmation d'annulation de commande           |
| `carousel`           | Carousel infini avec zoom, transitions et accessibilite              |
| `cart-sidebar`       | Panneau lateral du panier (ouverture/fermeture avec transition)      |
| `consent-banner`     | Bandeau de consentement cookies (RGPD)                               |
| `csrf-protection`    | Generation du token CSRF dans les formulaires                        |
| `dropdown`           | Menu deroulant (profil utilisateur) avec fermeture au clic exterieur |
| `favori`             | Toggle favori sur les cartes produits (requete AJAX + mise a jour UI)|
| `flash-tooltip`      | Affichage temporaire d'un message de confirmation                    |
| `nav-toggle`         | Menu mobile (ouverture/fermeture de la navigation hamburger)         |
| `submit-once`        | Protection contre la double soumission de formulaire                 |

#### Exemples detailles

**`carousel` — carousel infini avec gestion de l'accessibilite**

Le carousel est le controller le plus complexe du projet. Il gere le mode infini par clonage des premiers et derniers elements, une navigation par fleches clavier, un effet de zoom sur la carte centrale, des transitions d'animation sur les descriptions et une mise a jour en temps reel des attributs ARIA. Un element `aria-live` annonce le numero de slide aux technologies d'assistance.

```js
// Repositionnement silencieux apres la transition (via transitionend)
this._onTransitionEnd = () => {
  this.isAnimating = false;
  if (this.options.infinite) {
    this.resetInfinite();
  }
};
```

**`favori` — requetes AJAX et outlets Stimulus**

Le controller `favori` utilise l'API `fetch` pour envoyer une requete POST sans rechargement de page. Il utilise le mecanisme d'**outlets** de Stimulus pour communiquer avec le controller `flash-tooltip` voisin : si l'utilisateur n'est pas connecte (reponse HTTP 401), le message "Connectez-vous pour ajouter aux favoris" s'affiche automatiquement.

**`submit-once` — protection contre la double soumission**

Ce controller desactive le bouton de soumission des qu'un formulaire est envoye. Il masque le libelle du bouton, affiche un spinner et ajoute `aria-busy="true"`. Cela evite les doubles commandes ou les doubles inscriptions dues a un double-clic.

**`annulation` — boite de dialogue native**

Ce controller gere la confirmation avant d'annuler une commande. Il utilise l'element HTML natif `<dialog>`, recupere la reference et l'URL d'action depuis les attributs `data-*` du bouton, et soumet un formulaire POST avec le token CSRF si l'utilisateur confirme.

### 9.6 Architecture CSS -- Tailwind v4 et design tokens

#### Un seul fichier d'entree

Tout le CSS du projet est centralise dans un seul fichier : `assets/styles/app.css`. Il n'y a pas de `tailwind.config.js` : Tailwind v4 fonctionne entierement via des directives CSS.

```css
@import "tailwindcss";
@source "../../templates/**/*.twig";
@source "../../assets/**/*.js";
```

#### Les tokens de design (@theme)

La directive `@theme` definit l'ensemble des tokens du projet. Tailwind genere automatiquement les classes utilitaires (`bg-*`, `text-*`, `border-*`, etc.) a partir de ces variables.

| Token              | Usage                              |
|--------------------|-------------------------------------|
| `primary`          | Couleur de marque principale (chocolat) |
| `accent`           | CTA, prix, elements forts (framboise)   |
| `success`          | Statuts positifs (pistache)         |
| `warning`          | En attente, difficulte moyenne (ambre) |
| `danger`           | Erreurs, annulations (rouge)        |

Les tokens d'espacement utilisent `clamp()` pour s'adapter automatiquement a la largeur de l'ecran :

```css
--spacing-side: clamp(1rem, 15vw, 50rem);
--spacing-top:  clamp(1rem, 5vh, 5rem);
```

#### Les classes utilitaires (@layer components)

Des classes recurrentes sont definies dans `@layer components` : `.btn-cta`, `.btn-cta-sm`, `.btn-cta-outline`, `.page-title`, `.section-title`, `.container-main`, `.card`.

#### La police Luciole

La police **Luciole** est chargee localement avec `font-display: swap`, en formats `.woff2` et `.woff`. Elle est concue pour les personnes malvoyantes ou dyslexiques.

---

### 9.7 Developpement back-end -- controllers et services

#### Les controllers PHP

Le back-end est organise autour de **11 controllers** Symfony :

| Controller                | Route(s)                      | Role                                               |
|---------------------------|-------------------------------|----------------------------------------------------|
| `HomeController`          | `/`                           | Page d'accueil avec produits phares et carousel    |
| `ProduitsController`      | `/produits`, `/produits/{slug}` | Liste et fiche produit, filtres et recherche     |
| `RecettesController`      | `/recettes`, `/recettes/{slug}` | Liste et fiche recette, filtres et recherche     |
| `PanierController`        | `/panier`                     | Affichage et gestion du panier en session          |
| `CommandeController`      | `/commande/*`                 | Tunnel de commande en 3 etapes + Stripe            |
| `CompteController`        | `/mon-compte/*`               | Espace client : profil, commandes, favoris         |
| `SecurityController`      | `/connexion`, `/inscription`  | Authentification, inscription, verification email  |
| `ContactController`       | `/contact`                    | Formulaire de contact avec envoi d'email           |
| `FavoriController`        | `/favori/{type}/{id}`         | Toggle favori en AJAX (produits et recettes)       |
| `AvisController`          | `/produits/{slug}/avis`       | Soumission d'un avis note + commentaire            |
| `MentionsLegalesController` | `/mentions-legales`         | Page statique des mentions legales                 |

**CommandeController**

C'est le controller le plus complexe. Il gere le tunnel de commande en trois etapes sequentielles :

1. **`/commande/adresse`** : validation et stockage de l'adresse de livraison en session.
2. **`/commande`** : affichage du recapitulatif depuis le panier et la session.
3. **`/commande/paiement`** : creation d'une session Stripe Checkout et redirection.

Apres le paiement, Stripe redirige vers `/commande/succes` ou le controller enregistre la commande, vide le panier et envoie l'email de confirmation.

**FavoriController**

Appele exclusivement en AJAX. Il verifie que l'utilisateur est connecte (renvoie un 401 sinon), valide que la requete est bien AJAX, bascule l'etat favori, puis renvoie un JSON `{ favori: true|false }`.

**AvisController**

Accessible uniquement aux utilisateurs connectes (`#[IsGranted('ROLE_USER')]`). Valide le token CSRF, verifie que la note est comprise entre 1 et 5, puis cree ou met a jour l'avis de l'utilisateur sur le produit (un seul avis par couple utilisateur/produit, grace a la contrainte unique en base). L'avis est marque comme valide (`isValide = true`) directement a la soumission. La note moyenne et la liste des avis sont calcules par `AvisRepository` et affiches sur la fiche produit.

#### Les services

**`PanierService`**
Gere le panier stocke en session PHP. La structure en session est un tableau associatif `[produitId => quantite]`. En isolant cette logique dans un service, plusieurs controllers et le Live Component PanierLive peuvent l'utiliser sans dupliquer le code.

**`MailerService`**
Centralise tous les emails transactionnels. Il expose trois methodes : `envoyerConfirmationInscription()`, `envoyerConfirmationCommande()` et `envoyerMessageContact()`.

**`FactureService`**
Genere les factures PDF associees aux commandes confirmees, jointes en piece jointe a l'email de confirmation.

---

### 9.8 Le reste de src/

#### Les enums PHP

Le projet utilise deux **enums PHP natifs** (PHP 8.1+) :

`StatutCommande` : `EnAttente`, `Confirmee`, `Livree`, `Annulee`.
`Difficulte` : `Facile`, `Moyen`, `Difficile`.

Ces enums de type `string` permettent a Doctrine de les stocker directement en base et garantissent que seules les valeurs prevues peuvent etre assignees.

```php
enum StatutCommande: string {
    case EnAttente  = 'en_attente';
    case Confirmee  = 'confirmee';
    case Livree     = 'livree';
    case Annulee    = 'annulee';
}
```

#### Les repositories Doctrine

Le `ProduitRepository` contient la requete personnalisee la plus notable : `findMeilleursVendus()`. Elle utilise le Query Builder pour trier les produits par quantite totale commandee, avec fallback sur les plus recents si aucune commande n'existe.

```php
$this->createQueryBuilder('p')
    ->leftJoin(CommandeProduit::class, 'cp', 'WITH', 'cp.produit = p')
    ->andWhere('p.disponible = true')
    ->groupBy('p.id')
    ->orderBy('SUM(cp.quantite)', 'DESC')
    ->setMaxResults($limit)
```

#### Les extensions Twig

**`PrixExtension`** : filtre `|prix` pour formater les montants en euros selon les conventions francaises.

```twig
{{ produit.prix|prix }}  {# → "12,50 €" #}
```

**`PanierExtension`** : injecte la variable globale `panierCount` dans tous les templates Twig sans que les controllers aient besoin de la passer manuellement.

#### La classe UserChecker

Bloque la connexion si le compte n'a pas encore ete verifie par email. Si `isVerified` est `false`, une exception controlee est levee avec un message explicite.

#### Les fixtures

`AppFixtures` peuple la base de donnees avec des donnees realistes pour le developpement (categories, produits, recettes). Executees avec :

```bash
php bin/console doctrine:fixtures:load
```

---

## 10. Accessibilite

L'accessibilite est integree des la conception du projet.

**Typographie Luciole**
La police Luciole a ete concue specifiquement pour les personnes malvoyantes ou dyslexiques. Hauteur d'x elevee, formes de lettres distinctes, espacement genereux. Reconnue par des associations comme Valentin Hauy et disponible sous licence libre.

**Contrastes de couleurs**
La palette a ete construite avec des ratios de contraste suffisants. Les combinaisons principales depassent le ratio de 4.5:1 recommande par les WCAG. Les outils Colorable et Adobe Color ont ete utilises pour verifier ces ratios.

**Navigation clavier**
Tous les elements interactifs sont accessibles au clavier. `focus-visible:outline` evite d'afficher le contour lors d'un clic souris tout en le rendant visible lors de la navigation au clavier. Les boites de dialogue `<dialog>` gerent nativement le piegeage du focus.

**Attributs ARIA et HTML semantique**
`aria-label` sur les boutons icon-only, `aria-current="page"` sur le lien actif, `aria-invalid` sur les champs en erreur, `aria-describedby` pour relier messages d'aide et champs, `aria-live="polite"` sur les zones dynamiques (panier, carousel). Icones decoratives avec `aria-hidden="true"`.

Structure semantique : `<main>`, `<header>`, `<footer>`, `<nav>`, `<section>`, `<article>`, `<dialog>`. Hierarchie des titres respectee.

---

## 11. Securite

### 11.1 Authentification et gestion des utilisateurs

La securite est configuree dans `security.yaml`. Les mots de passe sont haches avec l'algorithme moderne de Symfony (`'auto'`). L'identifiant de connexion est l'adresse e-mail.

```yaml
firewalls:
    main:
        lazy: true
        provider: app_user_provider
        user_checker: App\Security\UserChecker
```

### 11.2 Inscription et verification d'e-mail

Lors de l'inscription, le mot de passe est hache et un jeton de verification est genere de maniere securisee :

```php
$token = bin2hex(random_bytes(32));
```

Ce jeton est envoye dans un lien de confirmation. Une fois valide, le compte est active et le jeton est supprime pour qu'il ne puisse pas etre reutilise.

### 11.3 Controle de l'etat du compte

La classe `UserChecker` personnalisee bloque la connexion si le compte n'a pas ete verifie par email, en levant une `CustomUserMessageAccountStatusException` avec un message explicite.

### 11.4 Protection des formulaires et des actions sensibles

Tous les formulaires integrent un token CSRF. L'annulation de commande verifie le token avant toute action. Les interactions AJAX (favoris) verifient que l'utilisateur est connecte et que les parametres sont valides.

### 11.5 Securisation de l'espace client

Le `CompteController` est protege par `#[IsGranted('ROLE_USER')]`. Les commandes affichees sont filtrees pour n'appartenir qu'a l'utilisateur connecte. L'annulation verifie que la commande ciblee appartient bien a l'utilisateur avant toute action.

### 11.6 Paiement en ligne avec Stripe

Le tunnel de commande comprend trois etapes : adresse, recapitulatif, paiement Stripe. Le montant est reconstruit cote serveur a partir du panier, sans faire confiance a un montant transmis par le navigateur. La cle secrete Stripe est utilisee cote serveur uniquement, via les variables d'environnement.

*Limite connue : la confirmation de commande repose sur l'arrivee de l'utilisateur sur la page succes. Une solution plus robuste utiliserait un webhook Stripe.*

### 11.7 Gestion des secrets et configuration

Les informations sensibles (DATABASE_URL, STRIPE_SECRET_KEY, MAILER_DSN) sont stockees dans `.env.local`, exclu du versioning git.

### 11.8 Limites actuelles et ameliorations possibles

- Utiliser davantage les formulaires Symfony avec validation integree
- Renforcer les contraintes sur les mots de passe
- Ajouter une expiration pour les jetons de verification
- Ameliorer la protection du formulaire de contact (token CSRF, anti-spam)
- Fiabiliser le tunnel de paiement avec un webhook Stripe

---

## 12. Tests

### Tests fonctionnels manuels

Chaque fonctionnalite a ete testee directement dans le navigateur :

- Inscription avec verification d'email (token de confirmation)
- Connexion avec un compte verifie et tentative avec un compte non verifie
- Ajout et suppression de produits dans le panier depuis la fiche produit et le catalogue
- Passage de commande complet : saisie d'adresse → recapitulatif → paiement Stripe (mode test)
- Annulation d'une commande depuis l'espace client
- Gestion des favoris (ajout, suppression, persistance apres rechargement)
- Formulaire de contact
- Navigation clavier sur l'ensemble des pages

### Scenario de test -- parcours complet utilisateur

**Objectif** : verifier qu'un utilisateur peut consulter les produits, ajouter un article au panier, passer commande et obtenir une confirmation apres paiement.

**Preconditions**
- L'utilisateur possede un compte cree et verifie par e-mail
- Au moins un produit est disponible dans le catalogue
- Le mode test Stripe est configure

**Etapes**

1. **Acces au site** : l'utilisateur arrive sur la page d'accueil et consulte les produits mis en avant.
2. **Consultation du catalogue** : il accede a la page des produits et ouvre la fiche d'un produit.
3. **Ajout au panier** : il ajoute un article au panier. Le compteur du panier est mis a jour visuellement.
4. **Consultation du panier** : il ouvre le panier, verifie le contenu, ajuste la quantite si besoin.
5. **Saisie de l'adresse** : il renseigne les informations de livraison.
6. **Recapitulatif** : le site affiche un resume avec les produits, l'adresse et le total.
7. **Paiement** : l'utilisateur est redirige vers Stripe Checkout en mode test.
8. **Confirmation** : apres validation, la commande est enregistree, le panier est vide et une page de confirmation est affichee.

**Resultats attendus**
- Le produit est bien ajoute au panier
- Le total de commande est correct
- La redirection vers Stripe fonctionne
- La commande est enregistree apres paiement
- Le panier est vide apres confirmation

**Cas d'echec verifies**
- Tentative d'acces au paiement avec un panier vide
- Tentative d'acces au recapitulatif sans adresse enregistree
- Annulation Stripe avec retour sur le site sans perte du panier

### Tests d'accessibilite

La navigation au clavier a ete verifiee sur tous les composants interactifs. Les contrastes de couleur ont ete controles avec Colorable. La structure HTML a ete validee avec une checklist personnalisee.

### Tests responsives

L'interface a ete verifiee aux trois breakpoints (mobile, tablette, desktop) via les outils de developpement du navigateur.

### Tests automatises

En complement des tests manuels, une suite de tests automatises a ete mise en place avec **PHPUnit 12**, **Symfony WebTestCase** et **Zenstruck Foundry v2**.

#### Infrastructure de test

| Outil | Role |
|-------|------|
| PHPUnit 12 | Framework de test PHP |
| Symfony WebTestCase | Client HTTP simulant un navigateur pour les tests fonctionnels |
| Zenstruck Foundry v2 | Fabrication d'entites en base de donnees (fixtures de test) |
| FakerPHP | Generation de donnees realistes (emails, noms, prix...) |

Chaque test s'execute sur une base de donnees isolee (`samydessert_test`). Le trait `ResetDatabase` de Foundry reiitialise la base entre chaque test, garantissant l'independance des cas.

#### Factories de donnees

Deux factories ont ete creees pour generer des entites de test sans effort :

- **`UtilisateurFactory`** : cree un utilisateur avec un email unique, un mot de passe hache (`motdepasse123`) et un compte verifie par defaut.
- **`ProduitFactory`** : cree un produit avec un nom, un slug, un prix et une image generee par Faker.

```php
$user    = UtilisateurFactory::createOne(['email' => 'test@test.com']);
$produit = ProduitFactory::createOne(['prix' => '9.90']);
$client->loginUser($user);
```

#### Categories de tests

**Tests unitaires** (sans base de donnees, sans requete HTTP) :

| Fichier | Ce qui est verifie |
|---------|-------------------|
| `tests/Service/PanierServiceTest.php` | Ajout, retrait, suppression, vidage et calcul du total panier (9 tests) |
| `tests/Entity/CommandeTest.php` | Calcul du total d'une commande, ajout de lignes, statuts (8 tests) |
| `tests/Service/MailerServiceTest.php` | Envoi d'emails (confirmation commande, contact) via mailer mocke (5 tests) |
| `tests/Security/UserCheckerTest.php` | Blocage de connexion si compte non verifie, message d'erreur (4 tests) |

**Tests fonctionnels** (requetes HTTP sur le vrai noyau Symfony) :

| Fichier | Ce qui est verifie |
|---------|-------------------|
| `tests/Controller/PagesTest.php` | Codes HTTP des pages publiques (200, 301, 404) — 11 tests |
| `tests/Controller/ContactControllerTest.php` | Affichage et soumission du formulaire de contact (2 tests) |
| `tests/Controller/ConnexionControllerTest.php` | Connexion valide, echec, redirection (3 tests) |
| `tests/Controller/InscriptionControllerTest.php` | Inscription valide, email deja utilise, champs manquants (5 tests) |
| `tests/Controller/PanierControllerTest.php` | Ajout, retrait, vidage du panier via les routes POST (6 tests) |
| `tests/Controller/CommandeControllerTest.php` | Acces sans connexion, panier vide, saisie d'adresse, CSRF (9 tests) |
| `tests/Controller/CompteControllerTest.php` | Acces protege, affichage de l'email (3 tests) |
| `tests/Controller/FavoriControllerTest.php` | Toggle favori (ajout/retrait), reponse JSON, auth requise (8 tests) |

#### Exemple : test du toggle favori

```php
public function testToggleProduitAjouteFavori(): void
{
    $client  = static::createClient();
    $user    = UtilisateurFactory::createOne();
    $produit = ProduitFactory::createOne();
    $client->loginUser($user);

    $client->request('POST', '/favori/produit/' . $produit->getId(), [], [], [
        'HTTP_X-Requested-With' => 'XMLHttpRequest',
    ]);

    $this->assertResponseIsSuccessful();
    $data = json_decode($client->getResponse()->getContent(), true);
    $this->assertTrue($data['favori']); // premier toggle → ajout
}
```

#### Exemple : test CSRF sur le formulaire d'adresse

Pour les formulaires proteges par un token CSRF, le test recupere le token depuis la page rendue avant de soumettre :

```php
$crawler   = $client->request('GET', '/commande/adresse');
$csrfToken = $crawler->filter('input[name="_token"]')->attr('value');

$client->request('POST', '/commande/adresse', [
    'firstName' => 'Jean', 'lastName' => 'Dupont',
    'address1'  => '12 rue de la Paix', 'postalCode' => '75001',
    'city'      => 'Paris', 'country' => 'FR',
    '_token'    => $csrfToken,
]);
$this->assertResponseRedirects('/commande');
```

#### Resultats

```
OK (74 tests, 132 assertions)
```

Les 74 tests s'executent avec la commande :

```bash
php bin/phpunit
```

---

## 13. Deploiement

### Environnement de developpement

Le projet est entierement contenerise avec **Docker**. L'architecture comprend :

- **nginx** : serveur web qui recoit les requetes HTTP et les transmet a PHP-FPM
- **php** : image PHP-FPM personnalisee qui execute le code Symfony
- **mysql** : base de donnees MySQL 8
- **adminer** : interface web de gestion de la base de donnees

Un service **init** s'execute au premier demarrage : il installe les dependances Composer, cree la base de donnees, execute les migrations et installe les assets.

Un service **assets** recompile Tailwind CSS et AssetMapper en boucle toutes les 30 secondes (le watch inotify n'etant pas supporte sous Windows avec Docker).

```bash
docker-compose up -d
# → site accessible sur http://localhost:8080
```

### Assets front-end

```bash
php bin/console tailwind:build      # Recompiler les styles Tailwind
php bin/console asset-map:compile   # Recompiler les assets JavaScript
```

### Deploiement en production

Le deploiement en production n'est pas encore realise. Les etapes prevues seraient :

1. Configurer les variables d'environnement (`DATABASE_URL`, `MAILER_DSN`, `STRIPE_SECRET_KEY`, `APP_SECRET`)
2. `composer install --no-dev --optimize-autoloader`
3. `php bin/console doctrine:migrations:migrate`
4. `php bin/console tailwind:build` et `php bin/console asset-map:compile`
5. `php bin/console cache:clear --env=prod`
6. Configurer Nginx pour pointer vers le dossier `public/`
7. Creer un dossier persistant pour les uploads images (`public/uploads/`) independant des deploiements

---

## 14. Evolution du projet

**Fonctionnalites a finaliser**
- Afficher et masquer le mot de passe sur les formulaires de connexion et d'inscription
- Calendrier des commandes dans l'administration
- Gestion des variations de produits (tailles, parfums)
- Permettre aux utilisateurs de proposer leurs propres recettes

**Ameliorations techniques**
- Renforcer le tunnel de paiement avec un webhook Stripe (actuellement la commande est enregistree cote serveur uniquement sur la redirection `/commande/succes`, sans verification cryptographique Stripe)
- Ajouter une expiration sur les tokens de verification d'email
- Ameliorer la protection du formulaire de contact (anti-spam)
- Moderation des avis depuis l'administration (actuellement les avis sont valides automatiquement)

**Infrastructure**
- Deplacer le dossier `docker/` et `docker-compose.yml` en dehors du projet
- Mettre en place un pipeline de deploiement continu (CI/CD)
- Migrer le stockage des images vers un service externe (AWS S3 ou equivalent) pour la production, afin que les uploads ne soient pas perdus lors d'un redeploi

---

## 15. Bilan personnel

A travers ce projet, j'ai appris a m'auto-former et a m'adapter a un environnement technologique en constante evolution. J'ai developpe ma capacite a apprendre de nouveaux langages, a lire et comprendre la documentation technique, et a utiliser des outils modernes, y compris des outils d'intelligence artificielle comme support d'apprentissage et de developpement.

Ce projet m'a permis de comprendre en profondeur la conception d'un site e-commerce, ainsi que les attentes liees au metier de web designer.

Une attention particuliere a ete portee a l'accessibilite, afin de rendre les outils web utilisables par tous. J'ai ainsi travaille sur le choix des couleurs, des contrastes, de la typographie, et sur la structuration des interfaces pour garantir une bonne lisibilite et une navigation claire.

**Ce que j'ai appris**

J'ai appris a analyser des sites concurrents afin d'identifier les bonnes pratiques. Le projet m'a permis de travailler sur le responsive design, la structuration d'un projet scalable, la decoupe des elements d'interface, l'utilisation d'un design system sur Figma, la creation d'un logo avec Affinity Designer, et l'accessibilite avec des outils comme userpersona.dev et BlooAI.

**Difficultes rencontrees**

L'une des principales difficultes concerne l'utilisation de Twig Components. Cette approche est interessante pour structurer l'interface avec Symfony, mais je l'ai trouvee moins souple que des solutions comme React pour les interfaces tres dynamiques. Certains cas n'avaient pas ete anticipes des le depart : options manquantes, variantes oubliees, besoins d'accessibilite a ajouter. Cela m'a oblige a revenir sur certains composants.

La prise en main de Symfony a egalement represente un defi important. Le framework est tres puissant mais propose un grand nombre de concepts a assimiler (services, securite, evenements, configuration). La transition vers Tailwind v4 a aussi necessite une adaptation.

Un probleme technique notable a ete la recursion infinie dans les composants Twig (voir Annexe C), qui m'a oblige a mettre en oeuvre une methodologie de debogage par isolation progressive pour en identifier la cause exacte.

**Points reussis**

Le point que je considere comme le plus reussi est la partie UI/UX design ainsi que l'integration de l'accessibilite des la conception. J'ai accorde une attention particuliere a la lisibilite, aux contrastes, a la typographie et a la navigation clavier, afin de rendre l'interface accessible au plus grand nombre.

**Ce que j'ameliorerais**

Si j'avais eu plus de temps, j'aurais mis en place la moderation des avis depuis l'administration, permis aux utilisateurs de proposer leurs propres recettes, et explore le modele marketplace (vente par des tiers). Ces evolutions feraient de SamyDessert une plateforme plus collaborative.

---

## 16. Conclusion

Le projet SamyDessert est un projet e-commerce structure, combinant conception UX/UI, accessibilite et developpement moderne.

Il permet de proposer une experience utilisateur claire, en offrant a la fois la consultation de recettes et la commande de desserts.

Ce projet demontre ma capacite a concevoir, structurer et developper une application web complete en respectant les bonnes pratiques actuelles : separation des responsabilites (MVC), composants reutilisables (Atomic Design), securite (CSRF, hachage, verification email), accessibilite (ARIA, contrastes, clavier) et performance (assets compiles, lazy loading).

---

## Annexe A -- Schema de la base de donnees

Afin de mieux visualiser la structure des donnees du projet, un schema relationnel a ete realise avec l'outil DBDiagram.

Ce schema met en evidence les differentes entites du projet ainsi que leurs relations :

- un utilisateur peut posseder plusieurs commandes
- une commande est composee de plusieurs lignes (CommandeProduit)
- un produit peut apparaitre dans plusieurs commandes
- une categorie regroupe plusieurs produits et recettes
- un utilisateur peut ajouter des produits et des recettes en favoris
- un utilisateur peut laisser un avis (note + commentaire) par produit

```dbml
Table utilisateur {
  id int [pk, increment]
  email varchar(180) [not null, unique]
  roles json [not null]
  password varchar(255) [not null]
  nom varchar(100) [null]
  prenom varchar(100) [null]
  telephone varchar(20) [null]
  adresse varchar(255) [null]
  ville varchar(100) [null]
  code_postal varchar(10) [null]
}

Table categorie {
  id int [pk, increment]
  nom varchar(100) [not null]
  slug varchar(100) [not null, unique]
}

Table produit {
  id int [pk, increment]
  nom varchar(255) [not null]
  description text [null]
  prix decimal(8,2) [not null]
  image_name varchar(255) [null]
  disponible boolean [not null, default: true]
  slug varchar(255) [not null, unique]
  created_at datetime [not null]
  updated_at datetime [null]
  categorie_id int [null, ref: > categorie.id]
}

Table recette {
  id int [pk, increment]
  titre varchar(255) [not null]
  slug varchar(255) [not null, unique]
  description text [null]
  contenu text [not null]
  image_name varchar(255) [null]
  duree int [null]
  portions int [null]
  difficulte varchar(20) [null]
  is_published boolean [not null, default: false]
  created_at datetime [not null]
  updated_at datetime [null]
  categorie_id int [null, ref: > categorie.id]
  produit_id int [null, ref: > produit.id]
}

Table commande {
  id int [pk, increment]
  utilisateur_id int [not null, ref: > utilisateur.id]
  date_commande datetime [not null]
  statut varchar(50) [not null]
  total decimal(8,2) [not null]
  reference varchar(50) [null]
  adresse_livraison varchar(255) [null]
  ville varchar(100) [null]
  code_postal varchar(10) [null]
  notes text [null]
}

Table commande_produit {
  commande_id int [pk, ref: > commande.id]
  produit_id int [pk, ref: > produit.id]
  quantite int [not null, default: 1]
  prix_unitaire decimal(8,2) [not null]
}

Table avis {
  id int [pk, increment]
  utilisateur_id int [not null, ref: > utilisateur.id]
  produit_id int [not null, ref: > produit.id]
  note int [not null]
  commentaire text [null]
  is_valide boolean [not null, default: false]
  created_at datetime [not null]

  indexes {
    (utilisateur_id, produit_id) [unique]
  }
}

Table utilisateur_produit_favori {
  utilisateur_id int [ref: > utilisateur.id]
  produit_id int [ref: > produit.id]
}

Table utilisateur_recette_favori {
  utilisateur_id int [ref: > utilisateur.id]
  recette_id int [ref: > recette.id]
}
```

---

## Annexe B -- Schema de fonctionnement de l'application

Lorsqu'un utilisateur interagit avec le site, une requete HTTP est envoyee au serveur selon le cycle suivant :

```
Utilisateur → Route → Controller → Service → Repository → Base de donnees → Vue Twig
```

1. **Route** : la requete est associee a une route Symfony qui determine quel controller executer.
2. **Controller** : orchestre le traitement, delegue la logique aux services.
3. **Service** : contient la logique metier (PanierService, MailerService, FactureService).
4. **Repository / Base de donnees** : recupere ou modifie les donnees via Doctrine ORM.
5. **Vue Twig** : genere le HTML final transmis au navigateur.

Cette architecture garantit une separation claire des responsabilites, une meilleure maintenabilite et une evolutivite du projet.

*[Capture : schema MVC a ajouter]*

---

## Annexe C -- Exemple de debogage : Bug OOM BlockStack

**Statut : RESOLU**

### Symptome

`Error: Allowed memory size of 1073741824 bytes exhausted` sur les pages `/recettes` et `/produits/{slug}`.

Stack trace : `vendor/symfony/ux-twig-component/src/BlockStack.php`

### Cause racine

Un commentaire Twig `{# #}` **imbrique** dans `Badge.html.twig` fermait prematurement le commentaire externe, laissant les exemples d'utilisation etre compiles comme du vrai code Twig.

```twig
{#
  - variant  string  ...
  {# warning = bg-warning-light #}   ← le #} ferme LES DEUX niveaux !

  Utilisation :
  <twig:Atoms:Badge>Nouveau</twig:Atoms:Badge>   ← plus dans un commentaire → code execute
  ...
#}
```

Badge s'appelait lui-meme 4 fois a chaque rendu → chaque appel re-declenchait 4 autres appels → recursion infinie → OOM.

### Fix applique

Suppression du `{# #}` imbrique. Remplacement des exemples par du texte plat.

**Regle retenue :**
- Ne jamais imbriquer `{# #}` dans un autre `{# #}` en Twig
- Ne jamais ecrire `<twig:MonComposant>` dans un commentaire Twig (execute meme dans un `{# #}`)

### Methodologie de debogage

La technique ayant permis de trouver la cause : **commenter tout le `{% block body %}`, puis rajouter les elements un par un** jusqu'a identifier celui qui declenchait le crash.

| Etape | Resultat |
|-------|----------|
| body vide | OK |
| + hero HTML pur | OK |
| + vraie boucle recettes (1 item) | CRASH |
| + difficulte hardcodee | CRASH |
| Badge directement sur la page | CRASH |
| Remplacer Badge par Link | OK → **Badge est fautif** |
| Lire le cache Twig compile de Badge | recursion infinie detectee |

**Lecon** : quand un crash OOM est difficile a localiser dans la stack trace, l'isolation par suppression progressive est plus efficace que d'analyser le code vendor.
