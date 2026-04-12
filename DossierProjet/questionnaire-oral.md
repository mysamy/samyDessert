# Questionnaire oral — SamyDessert

Lis chaque fiche à voix haute comme si tu expliquais à quelqu'un. Ferme ensuite le fichier et réessaie sans regarder.

---

## Controllers Stimulus

---

### `annulation_controller.js`

**C'est quoi le problème que ça résout ?**
Sans ce controller, si l'utilisateur clique sur "Annuler la commande", la commande serait annulée directement sans demander confirmation. C'est dangereux.

**Comment ça marche ?**
Chaque bouton "Annuler" dans l'espace client porte des attributs `data-*` : la référence de la commande, l'URL d'action et le token CSRF. Quand on clique, le controller lit ces attributs, injecte la référence dans la modale pour afficher "Voulez-vous annuler CMD-2026-00042 ?", puis ouvre le `<dialog>` natif. Si l'utilisateur confirme, le controller crée un formulaire POST dynamiquement avec le token CSRF et le soumet. Si il annule, le dialog se ferme et rien ne se passe.

**Pourquoi un `<dialog>` natif ?**
Parce qu'il gère automatiquement le piégeage du focus (on ne peut pas sortir avec Tab tant que la modale est ouverte) et la touche Échap. Pas besoin d'écrire ce comportement à la main.

**Pourquoi créer un form dynamiquement plutôt que fetch ?**
Parce qu'un submit classique déclenche une navigation complète, ce qui permet au serveur de renvoyer une redirection avec un message flash "Commande annulée". Turbo Drive intercepte quand même le submit, donc la navigation reste rapide.

---

### `carousel_controller.js`

**C'est quoi le problème que ça résout ?**
Je voulais un carousel infini avec un zoom sur la carte centrale, des animations directionnelles et une navigation au clavier — sans bibliothèque externe.

**Comment ça marche ?**
Le fichier contient deux choses : une classe `Carousel` autonome en JavaScript vanilla, et un controller Stimulus minimal qui l'instancie dans `connect()` et la détruit dans `disconnect()`. La classe fait tout le travail.

**Mode infini :** les premiers et derniers éléments sont clonés et ajoutés en début et fin de liste. Quand une transition se termine sur un clone, on se repositionne silencieusement sur le vrai élément — l'utilisateur ne voit pas le saut.

**Protection double-clic :** le drapeau `isAnimating` est mis à `true` au début de chaque navigation et remis à `false` à la fin de la transition. Un `setTimeout` de secours évite un blocage si l'événement `transitionend` ne se déclenche pas.

**Accessibilité :** `updateAccessibility()` met à jour `aria-current`, `inert` et `tabindex` à chaque déplacement. La navigation au clavier avec les flèches est gérée sur le conteneur racine.

**Pourquoi la convention BEM uniquement ici ?**
Parce que le JavaScript génère et manipule des classes CSS dynamiquement. BEM rend les relations entre éléments explicites directement dans le code JS, sans avoir à ouvrir le CSS. Pour tous les autres composants, Tailwind suffit.

---

### `cart_sidebar_controller.js`

**C'est quoi le problème que ça résout ?**
La sidebar du panier doit s'ouvrir avec une animation de glissement depuis la droite, et se fermer avec la même animation en sens inverse. Le `<dialog>` natif n'a pas d'animation par défaut.

**Comment ça marche ?**
À l'ouverture, `showModal()` est appelé d'abord (ce qui positionne le dialog en overlay), puis la classe Tailwind `translate-x-full` est retirée pour déclencher la transition CSS de glissement. À la fermeture, on remet `translate-x-full` et on attend 300ms avant d'appeler `close()`, pour laisser l'animation se terminer avant que le dialog disparaisse du DOM.

La touche Échap est interceptée avec `handleCancel()` pour qu'elle déclenche l'animation de fermeture au lieu de fermer instantanément. Un clic sur le fond (backdrop) est également géré.

---

### `favori_controller.js`

**C'est quoi le problème que ça résout ?**
Je voulais permettre d'ajouter un produit aux favoris directement depuis la carte, sans rechargement de page, avec un retour visuel immédiat et un message si l'utilisateur n'est pas connecté.

**Comment ça marche ?**
Au clic, le controller envoie une requête POST en AJAX via `fetch` vers `/favori/{type}/{id}`. Si le serveur répond 401 (non connecté), il trouve le controller `flash-tooltip` voisin et appelle sa méthode `show()` pour afficher "Connectez-vous pour ajouter aux favoris". Si tout va bien, il reçoit un JSON `{ favori: true }` et met à jour la valeur Stimulus `activeValue`. Stimulus appelle alors automatiquement `activeValueChanged()` qui anime le cœur (clip-path pour remplir ou vider le cœur SVG) et met à jour l'aria-label.

**Pourquoi `activeValue` plutôt que modifier directement le DOM ?**
Parce que Stimulus gère automatiquement les callbacks quand une valeur change. C'est plus propre et ça sépare la logique métier (récupérer la réponse serveur) de la logique d'affichage (mettre à jour le DOM).

---

### `flash_tooltip_controller.js`

**C'est quoi le problème que ça résout ?**
J'avais besoin d'un message temporaire qui apparaît quelques secondes puis disparaît automatiquement — par exemple "Connectez-vous pour ajouter aux favoris".

**Comment ça marche ?**
`show()` retire la classe `hidden` du message et lance un timer. Au bout de `durationValue` millisecondes (3 secondes par défaut), la classe `hidden` est remise. `clearTimeout` est appelé à chaque `show()` pour éviter qu'un ancien timer cache le message trop tôt si on clique plusieurs fois rapidement.

**Pourquoi c'est un controller séparé ?**
Parce qu'il est réutilisable partout. Le controller `favori` l'appelle via `application.getControllerForElementAndIdentifier()` pour communiquer avec lui sans coupler les deux controllers.

---

### `nav_toggle_controller.js`

**C'est quoi le problème que ça résout ?**
Le menu mobile doit s'ouvrir et se fermer avec une animation, et se fermer automatiquement si on passe en desktop ou si on appuie sur Échap.

**Comment ça marche ?**
Le bouton hamburger déclenche `toggle()`. À l'ouverture, `show()` est appelé sur le `<dialog>` et la classe d'animation `nav-menu-enter` est ajoutée. À la fermeture, la classe `nav-menu-leave` est ajoutée et on attend la fin de l'animation CSS (`animationend`) avant d'appeler `close()`. L'icône hamburger est remplacée par une croix à l'ouverture.

Des écouteurs globaux sur `resize` et `keydown` ferment le menu si on redimensionne la fenêtre au-dessus de 1024px ou si on appuie sur Échap. Ces écouteurs sont retirés dans `disconnect()` pour ne pas fuiter.

---

### `submit_once_controller.js`

**C'est quoi le problème que ça résout ?**
Si l'utilisateur double-clique sur "Passer la commande", deux commandes pourraient être créées. Ce controller empêche ça.

**Comment ça marche ?**
Dès que le formulaire est soumis, `submit()` est appelé. Il désactive le bouton (`disabled = true`), ajoute `aria-busy="true"` pour les lecteurs d'écran, masque le texte du bouton et affiche le spinner. Le formulaire ne peut plus être resoumis jusqu'à ce que la page soit rechargée.

---

### `dropdown_controller.js`

**C'est quoi le problème que ça résout ?**
Le menu déroulant du profil utilisateur doit se fermer quand on clique ailleurs sur la page.

**Comment ça marche ?**
À la connexion, un écouteur `click` est ajouté sur tout le `document`. À chaque clic, on vérifie si le clic est à l'intérieur du controller (`this.element.contains(e.target)`). Si non, on ferme le menu. Cet écouteur est retiré dans `disconnect()` pour ne pas fuiter.

---

### `password_toggle_controller.js`

**C'est quoi le problème que ça résout ?**
L'utilisateur doit pouvoir afficher ou masquer le mot de passe dans les formulaires de connexion et d'inscription.

**Comment ça marche ?**
`toggle()` vérifie si le type du champ est `password`. Si oui, il le passe en `text` (visible), affiche l'icône "masquer" et cache l'icône "afficher". Sinon il fait l'inverse. L'`aria-label` du bouton est aussi mis à jour pour les lecteurs d'écran.

---

### `consent_banner_controller.js`

**C'est quoi le problème que ça résout ?**
Afficher une bannière de consentement cookies RGPD uniquement si l'utilisateur n'a pas encore fait son choix.

**Comment ça marche ?**
Dans `connect()`, le controller vérifie si le cookie `cookie_consent` existe déjà. Si non, il appelle `show()` sur le `<dialog>` pour afficher la bannière. Les boutons "Accepter" et "Refuser" appellent `accept()` ou `reject()`, qui écrivent le cookie avec une durée d'un an et ferment le dialog.

---

### `star_rating_controller.js`

**C'est quoi le problème que ça résout ?**
Le sélecteur d'étoiles pour laisser un avis doit mettre en surbrillance les étoiles au survol, et mémoriser la sélection quand on clique.

**Comment ça marche ?**
Le composant est fait de 5 inputs radio invisibles et de 5 icônes étoiles. `highlight()` colore toutes les étoiles jusqu'à l'index survolé. `reset()` relit l'input coché pour revenir à l'état sélectionné si on quitte la zone sans cliquer. `select()` fixe définitivement la couleur des étoiles quand on clique.

---

### `confirm_controller.js` et `image_zoom_controller.js`

Ces deux controllers font la même chose : ouvrir et fermer un `<dialog>` natif. `open()` appelle `showModal()`, `close()` appelle `close()`, et `closeOnBackdrop()` détecte un clic sur le fond. `confirm` est utilisé pour les boîtes de confirmation génériques, `image-zoom` pour agrandir les images produits au clic.

---

### `csrf_protection_controller.js`

**C'est quoi le problème que ça résout ?**
Symfony génère les tokens CSRF côté serveur. Mais quand Turbo intercepte les soumissions de formulaires, les tokens doivent être transmis d'une façon compatible.

**Comment ça marche ?**
Ce fichier est fourni par Symfony UX — je ne l'ai pas écrit. Il écoute les événements `submit` et `turbo:submit-start`. À chaque soumission, il génère un token CSRF aléatoire, le place dans un cookie sécurisé (`SameSite=Strict`) et l'envoie aussi dans un header HTTP pour les soumissions Turbo. Côté serveur, Symfony vérifie que le token dans le champ caché correspond au cookie.

---

## Questions que le jury peut poser

**Pourquoi Stimulus plutôt que React ou Vue ?**
Stimulus n'est pas un framework de rendu — il ajoute du comportement à un HTML déjà présent dans la page. Symfony + Twig génère le HTML côté serveur. Avec React, il faudrait dupliquer la logique de rendu côté client. Stimulus est cohérent avec l'architecture Symfony : le serveur reste maître du HTML.

**C'est quoi un outlet Stimulus ?**
C'est un mécanisme qui permet à un controller d'appeler directement des méthodes d'un autre controller voisin dans le DOM. Dans mon projet, `favori` utilise un outlet vers `flash-tooltip` pour afficher le message "Connectez-vous". C'est plus propre qu'émettre un événement custom ou accéder directement au DOM.

**C'est quoi Turbo Drive ?**
Turbo Drive intercepte tous les clics sur les liens et les soumissions de formulaires. Au lieu de recharger toute la page, il récupère le HTML de la nouvelle page via fetch et remplace uniquement le `<body>`. Résultat : la navigation est aussi rapide qu'une SPA, mais sans écrire de JavaScript.

**C'est quoi un Turbo Frame ?**
Un `<turbo-frame>` est une zone isolée de la page. Quand un lien ou un formulaire à l'intérieur du frame est activé, seule cette zone est mise à jour, pas toute la page. Dans mon projet, j'utilise un Turbo Frame pour le filtrage des produits par catégorie.

**Pourquoi `<dialog>` natif plutôt qu'une div ?**
Le `<dialog>` natif gère automatiquement le piégeage du focus (Tab ne sort pas de la modale), la touche Échap, et l'attribut `aria-modal`. Ce sont des comportements d'accessibilité complexes à reproduire à la main.

**C'est quoi `inert` dans le carousel ?**
`inert` est un attribut HTML qui désactive d'un coup tout le contenu interactif d'un élément : focus, événements, Tab. Je l'utilise sur les slides hors champ pour que les lecteurs d'écran et la navigation clavier ignorent les cartes non visibles.
