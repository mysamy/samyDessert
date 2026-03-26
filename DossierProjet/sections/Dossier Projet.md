# **Samy Ben Hamida – Projet SamyDessert**

# **Table des matières**

1. Présentation personnelle  
     1.1 Qui suis-je et mon parcours  
2. Présation du projet SamyDessert  
     2.1 Genèse du projet et vision  
     2.2 Objectifs du projet  
3. Architecture technique  
     3.1 Stack technologique  
     3.2 Outils et services complémentaires  
4. Conception UX/UI  
     4.1 Analyse et inspiration  
     4.2 Personas utilisateurs  
     4.3 User flow  
     4.4 Choix visuels et accessibilité  
     4.5 Identité visuelle  
     4.6 Design system  
     4.7 Wireframes et maquettes  
5. Méthodologie de conception  
     5.1 Démarche de conception  
     5.2 User stories  
6. Conception de la base de données  
7. Développement front-end  
     7.1 Approche Atomic Design  
     7.2 Les atomes  
8. Accessibilité  
9. Sécurité  
10. Tests  
11. Déploiement  
12. Évolution du projet  
13. Conclusion

---

## **Qui suis-je et mon parcours**

Je m'appelle Samy Ben Hamida, j'ai 34 ans. Après l’obtention d’un baccalauréat scientifique, j’ai effectué une première année d’études en informatique à l’université Paris Descartes.

Je suis aujourd’hui en formation de développeur web et web mobile à l’ESRP Auxilia, dans le cadre d’un parcours en alternance. Cette formation s’organise avec un rythme d’une semaine en centre et une semaine en stage.

J’effectue mon stage au sein de l’association Créative Handicap, qui a pour objectif de rendre l’art et les métiers du numérique accessibles à tous, notamment à travers des formations en design web.

Je suis une personne calme, motivée, avec un bon esprit d’équipe. J’apprécie les défis et je dispose d’une bonne capacité d’analyse et de logique.

---

## **La Genèse du Projet et ma Vision**

Le projet SamyDessert est né de ma passion pour les desserts faits maison. J’ai l’habitude de préparer des desserts que je partage avec mes collègues, ce qui m’a permis de constater un intérêt réel pour des recettes simples et accessibles.

J’ai identifié plusieurs problèmes dans les plateformes existantes : certaines sont complexes, peu accessibles ou proposent des recettes coûteuses et difficiles à reproduire. À l’inverse, les plateformes de commande ne permettent pas toujours de comprendre ou reproduire les recettes.

SamyDessert a pour objectif de proposer une plateforme hybride. L’utilisateur peut soit consulter des recettes simples, économiques et faciles à réaliser, soit commander directement des desserts pour une livraison rapide.

Une attention particulière est portée à l’accessibilité du site afin de garantir une expérience claire, fluide et compréhensible pour tous.

---

## **Architecture Technique Générale**

Le projet repose sur Symfony et PHP pour le back-end. Symfony offre une structure robuste et modulaire permettant de maintenir un code organisé et évolutif.

Twig est utilisé comme moteur de templating afin de séparer la logique du rendu. Tailwind CSS permet de construire rapidement des interfaces responsives grâce à une approche utilitaire moderne.

La base de données repose sur MySQL, permettant de structurer les données liées aux utilisateurs, produits, recettes et commandes.

JavaScript et Stimulus sont utilisés pour ajouter des interactions côté client de manière légère et structurée.

L’environnement de développement est conteneurisé avec Docker, avec Nginx comme serveur web et Adminer pour la gestion de la base de données.

---

## **Outils et Services Complémentaires**

Stripe est utilisé pour gérer les paiements en ligne de manière sécurisée.

DBDiagram est utilisé pour concevoir le schéma de la base de données.

Mailtrap permet de tester l’envoi d’emails en environnement de développement.

Des outils comme Coolors, Adobe Color et Colorable ont été utilisés pour définir et tester les palettes de couleurs.

Un outil d’analyse d’accessibilité comme BlooAI est prévu pour tester le site une fois développé.

---

## **Conception UX/UI avec Figma**

### **Analyse et Inspiration**

Une phase d’analyse a été réalisée à partir de sites existants afin d’identifier les bonnes pratiques en matière d’UX.

📸 capture d’écran inspiration à ajouter

---

### **Personas**

Des personas ont été définis pour représenter les différents types d’utilisateurs.

📸 capture d’écran persona à ajouter

---

### **User Flow**

Un user flow a été conçu pour modéliser le parcours utilisateur.

📸 capture d’écran user flow à ajouter

---

### **Choix Visuels et Accessibilité**

Une palette de couleurs cohérente a été définie avec différentes teintes.

La typographie Luciole a été choisie pour améliorer la lisibilité et l’accessibilité.

📸 capture palette couleurs  
📸 capture typographie

---

### **Identité Visuelle**

Le logo du projet a été conçu avec Affinity Designer en cohérence avec la palette de couleurs.

📸 capture logo

---

### **Design System**

Un mini design system a été mis en place avec des composants réutilisables et des variables de couleurs.

📸 capture design system

---

### **Wireframes et Maquettes**

Les interfaces ont été conçues en mobile-first, puis adaptées tablette et desktop.

📸 mobile  
📸 tablette  
📸 desktop

## **Développement Front-End – Approche Atomic Design**

Le front-end est basé sur une approche Atomic Design.

Les composants les plus simples (Atoms) ont été développés en premier sous forme de composants Twig.

Ces atomes incluent notamment :

* boutons  
* inputs  
* labels  
* liens  
* images  
* icônes

Chaque composant est conçu pour être réutilisable, cohérent et accessible.

Tailwind CSS est utilisé pour le style, permettant une intégration rapide et responsive.

---

## **Accessibilité**

L’accessibilité est intégrée dès la conception :

* typographie adaptée (Luciole)  
* contrastes vérifiés  
* navigation clavier  
* attributs ARIA  
* structure HTML sémantique

---

## **Conclusion**

Le projet SamyDessert est un projet e-commerce structuré, combinant conception UX/UI, accessibilité et développement moderne.

Il permet de proposer une expérience utilisateur claire, en offrant à la fois la consultation de recettes et la commande de desserts.

Ce projet démontre ma capacité à concevoir, structurer et développer une application web complète en respectant les bonnes pratiques actuelles.

## **`1. Sécurité`**

### **`1.1 Vue d’ensemble`**

### **`1.2 Authentification et gestion des utilisateurs`**

### **`1.3 Inscription et vérification d’e-mail`**

### **`1.4 Protection des formulaires et des actions sensibles`**

### **`1.5 Sécurisation de l’espace client`**

### **`1.6 Paiement en ligne avec Stripe`**

### **`1.7 Gestion des secrets et configuration`**

### **`1.8 Limites actuelles et améliorations possibles`**

## **`2. Déploiement`**

## **`3. Évolution du projet`**

---

### **`Première correction importante`**

`Tu dois supprimer dans ton PDF toutes les phrases comme :`

* `“Ce que tu peux dire en analyse”`  
* `“Remarque importante pour ton PDF”`  
* `“Ce qui est bien dans ton code”`  
* `“Point moderne / recommandé”`  
* `“Observation critique utile”`

`Ces passages étaient utiles pour préparer le texte, mais ils ne doivent pas apparaître dans la version finale.`

---

### **`Version propre et rédigée de ta partie Sécurité`**

`Tu peux remplacer toute ta section actuelle par celle-ci :`

# **`Sécurité`**

`La sécurité est un aspect essentiel du projet SamyDessert. Plusieurs mécanismes ont été mis en place afin de protéger les comptes utilisateurs, les données personnelles, les actions sensibles et le processus de commande.`

## **`Authentification et gestion des utilisateurs`**

`La sécurité principale de l’application est configurée dans le fichier security.yaml. Cette configuration définit la manière dont les utilisateurs sont authentifiés, comment leurs mots de passe sont protégés, comment Symfony retrouve un utilisateur en base de données et quelles zones du site doivent être sécurisées.`

`Les mots de passe des utilisateurs sont protégés grâce au système de hachage de Symfony :`

`password_hashers:`

   `Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'`

`Cette configuration garantit que les mots de passe ne sont jamais stockés en clair dans la base de données. Symfony applique automatiquement un algorithme de hachage moderne et adapté, ce qui renforce la sécurité en cas de fuite de données.`

`Les utilisateurs sont chargés depuis la base de données via l’entité Utilisateur, en utilisant l’adresse e-mail comme identifiant de connexion :`

`providers:`

   `app_user_provider:`

       `entity:`

           `class: App\Entity\Utilisateur`

           `property: email`

`Le pare-feu principal de l’application est défini dans la section firewalls. Il gère la sécurité des utilisateurs connectés, utilise le fournisseur d’utilisateurs défini précédemment et s’appuie sur un UserChecker personnalisé pour appliquer des règles métier supplémentaires lors de l’authentification.`

`firewalls:`

   `main:`

       `lazy: true`

       `provider: app_user_provider`

       `user_checker: App\Security\UserChecker`

`L’authentification se fait par formulaire, avec une route de connexion dédiée et une redirection après connexion réussie. La déconnexion est également prévue de manière explicite, ce qui permet de fermer proprement la session utilisateur.`

`L’entité Utilisateur constitue elle aussi un élément central de la sécurité. Elle implémente les interfaces UserInterface et PasswordAuthenticatedUserInterface, ce qui permet à Symfony de l’utiliser directement dans le système d’authentification. L’adresse e-mail est unique pour chaque compte, ce qui évite les doublons et permet une identification fiable. Les rôles sont stockés sous forme de tableau JSON, avec l’ajout automatique de ROLE_USER pour tous les utilisateurs authentifiés.`

`L’entité contient également un mécanisme de vérification d’adresse e-mail avec les champs isVerified et verificationToken. Cela permet de distinguer les comptes activés des comptes encore en attente de confirmation.`

## **`Inscription et vérification d’e-mail`**

`Le contrôleur SecurityController gère la connexion, l’inscription et la confirmation d’adresse e-mail. Lors de l’inscription, plusieurs vérifications sont effectuées : le mot de passe doit correspondre à sa confirmation, contenir au moins huit caractères, et l’adresse e-mail ne doit pas déjà exister dans la base de données.`

`Avant d’être enregistré, le mot de passe est haché avec le composant de sécurité de Symfony :`

`$user->setPassword($hasher->hashPassword($user, $password));`

`Un jeton de vérification est ensuite généré de manière sécurisée avec random_bytes() :`

`$token = bin2hex(random_bytes(32));`

`Ce jeton est envoyé à l’utilisateur dans un lien de confirmation généré en URL absolue. Lorsqu’il clique sur ce lien, l’application vérifie que le jeton existe bien, active le compte, puis supprime le jeton afin qu’il ne puisse pas être réutilisé.`

`Cette logique permet de limiter les faux comptes et de s’assurer que l’adresse e-mail utilisée lors de l’inscription appartient réellement à l’utilisateur.`

## **`Contrôle de l’état du compte`**

`Le projet utilise également une classe UserChecker personnalisée. Celle-ci permet d’ajouter une règle métier de sécurité au moment de la connexion : un utilisateur ne peut pas se connecter tant que son compte n’a pas été vérifié par e-mail.`

`Si le compte n’est pas encore activé, une exception contrôlée est levée et un message explicite est renvoyé à l’utilisateur. Cette approche renforce la sécurité de l’authentification en ajoutant une condition supplémentaire au-delà du simple mot de passe.`

## **`Protection des formulaires et des actions sensibles`**

`Les formulaires de connexion et d’inscription intègrent un token CSRF, ce qui permet de limiter les attaques de type falsification de requête intersite. Le formulaire de connexion utilise le jeton attendu par Symfony Security, tandis que le formulaire d’inscription inclut également un token caché.`

`Dans le cas de l’espace client, la protection CSRF est aussi appliquée lors de l’annulation d’une commande. Avant toute annulation, le contrôleur vérifie que le token reçu est valide. Cela empêche qu’une action sensible puisse être déclenchée par une requête externe non légitime.`

`Certaines actions dynamiques, comme l’ajout ou la suppression de favoris, vérifient également que l’utilisateur est connecté, que les paramètres reçus sont valides et que les éléments ciblés existent bien en base de données. Cela permet de sécuriser les interactions AJAX de l’application.`

## **`Sécurisation de l’espace client`**

`Le contrôleur CompteController est protégé par l’attribut #[IsGranted('ROLE_USER')], ce qui réserve l’accès à l’espace personnel aux seuls utilisateurs connectés.`

`Lors de l’affichage des commandes, l’application ne récupère que les commandes appartenant à l’utilisateur authentifié. Lors de l’annulation d’une commande, une vérification supplémentaire garantit que la commande ciblée appartient bien à l’utilisateur connecté. Cela évite qu’un client puisse agir sur les commandes d’un autre simplement en modifiant un identifiant dans l’URL.`

`Un contrôle métier est également appliqué sur l’état de la commande : seules les commandes confirmées peuvent être annulées. Cette règle protège l’intégrité du processus de commande et évite les incohérences fonctionnelles.`

## **`Paiement en ligne avec Stripe`**

`Le paiement en ligne est géré via Stripe. Cette approche permet de ne pas faire transiter les données bancaires directement par l’application, ce qui limite fortement les risques liés au traitement des paiements.`

`La clé secrète Stripe est utilisée côté serveur uniquement, via les variables d’environnement. Le montant du paiement est reconstruit à partir des données du panier côté serveur, sans faire confiance à un montant transmis par le navigateur. Cette méthode est plus sûre et permet de conserver la cohérence entre le panier, le compte utilisateur et la session de paiement.`

`Cependant, la création finale de la commande confirmée repose actuellement sur l’arrivée de l’utilisateur sur la page de succès après paiement. Cette approche reste fonctionnelle, mais elle pourrait être renforcée. Dans une version plus robuste, il serait préférable de confirmer définitivement la commande à partir d’une vérification serveur indépendante, par exemple via la récupération sécurisée de la session Stripe ou l’utilisation d’un webhook Stripe.`

## **`Gestion des secrets et configuration`**

`Le projet utilise les variables d’environnement pour stocker les informations sensibles telles que la connexion à la base de données, les accès SMTP ou les clés Stripe. Les secrets sont placés dans .env.local, ce qui permet d’éviter leur diffusion dans le code source versionné.`

`Cette séparation entre le code et la configuration constitue une bonne pratique importante. Elle permet d’adapter facilement l’application selon l’environnement de développement ou de production, tout en limitant les risques de fuite d’informations sensibles.`

`En production, il serait préférable d’utiliser directement les variables d’environnement du serveur ou un système de gestion de secrets dédié. De plus, certaines configurations tolérables en développement, comme l’utilisation du compte root pour la base de données, ne devraient pas être conservées en production.`

## **`Limites actuelles et améliorations possibles`**

`La base de sécurité du projet est solide, mais plusieurs améliorations peuvent encore être envisagées. Il serait possible d’utiliser davantage les formulaires Symfony avec validation intégrée, de renforcer les contraintes sur les mots de passe, d’ajouter une expiration pour les jetons de vérification, d’améliorer la protection du formulaire de contact avec un token CSRF et un système anti-spam, et de fiabiliser encore davantage le tunnel de paiement avec une confirmation serveur indépendante.`

1. 

### **Principe**

Twig permet d’étendre ses fonctionnalités grâce à des extensions personnalisées.  
 J’ai utilisé ce mécanisme pour créer un filtre réutilisable directement dans mes vues, ce qui me permet de centraliser une logique spécifique et d’éviter les répétitions dans mon code.

Dans mon cas, j’ai créé un filtre nommé `prix` permettant de formater les montants en euros de manière cohérente sur l’ensemble du site.

---

### **Implémentation**

J’ai défini une classe `PrixExtension` qui hérite de `AbstractExtension`.

Dans cette classe, j’ai déclaré un filtre Twig personnalisé :

* Nom du filtre : `prix`  
* Méthode associée : `formatPrix`

Cette méthode accepte différents types de données (`float`, `int`, `string` ou `null`) afin de garantir une certaine flexibilité dans son utilisation.

---

### **Fonctionnement**

Le filtre que j’ai développé applique les règles suivantes :

* Si le montant est `null`, j’affiche par défaut `0,00 €`  
* Sinon :  
  * je convertis la valeur en nombre  
  * je la formate avec :  
    * deux décimales  
    * une virgule comme séparateur décimal  
    * un espace comme séparateur de milliers  
  * j’ajoute le symbole euro à la fin

Par exemple :

* `12` devient `12,00 €`  
* `1234.5` devient `1 234,50 €`

---

### **Utilisation dans Twig**

Une fois mon extension enregistrée, je peux utiliser le filtre directement dans mes templates :

{{ produit.prix|prix }}

Cela me permet d’assurer un affichage uniforme des prix sur l’ensemble de mon site sans répéter la logique de formatage.

---

### **Intérêt dans mon projet**

La mise en place de cette extension Twig m’apporte plusieurs avantages :

* je centralise la logique de formatage des prix  
* j’améliore la lisibilité de mes templates  
* j’évite la duplication de code  
* je facilite la maintenance et les évolutions futures 

