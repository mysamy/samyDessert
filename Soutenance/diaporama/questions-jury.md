# Questions pièges — Jury DWWM SamyDessert

> Pour chaque question : essaie de répondre à voix haute SANS regarder la réponse.
> Si tu bloques, la réponse est dans l'oral.md à la slide indiquée.

---

## Architecture & MVC

**Pourquoi tu as mis la logique dans un Service et pas directement dans le Controller ?**
> Pour pouvoir tester `PanierService` sans simuler de requête HTTP. Si la logique est dans le Controller, elle est couplée au cycle HTTP — tu ne peux pas l'appeler dans un test unitaire facilement. → Slide 25

**C'est quoi la différence entre un Controller et un Service dans Symfony ?**
> Controller = point d'entrée HTTP, reçoit la requête, retourne une réponse. Il délègue. Service = logique métier pure, pas de dépendance à HTTP. → Slide 11

**Tu parles d'autowiring — comment Symfony sait quoi injecter ?**
> Par le type-hint dans le constructeur. Symfony lit `PanierService $panier` et cherche dans son container un service de ce type. Il n'y en a qu'un — il l'injecte. → Slide 10

**Pourquoi le MVC de Symfony n'a pas de Model au sens strict ?**
> Dans Symfony, le "Model" est divisé en deux : l'entité (la structure des données) et le Repository (l'accès aux données). Le Controller ne touche ni l'un ni l'autre directement — il passe par les Services. → Slide 11

---

## Base de données & Doctrine

**Pourquoi tu as utilisé `DECIMAL(8,2)` et pas `float` pour les prix ?**
> Les floats sont en base binaire — `0.1 + 0.2` ne vaut pas exactement `0.3`. Sur des montants financiers c'est inacceptable. `DECIMAL` stocke le nombre exact. → Slide 15

**C'est quoi le "Data Mapper pattern" de Doctrine ?**
> L'entité ne sait pas qu'elle est persistée — elle n'hérite de rien, pas de `save()`, pas de `delete()`. C'est l'EntityManager qui l'observe via l'Unit of Work et génère le SQL au `flush()`. → Slide 10

**Pourquoi tu dupliques le prix dans `CommandeProduit` ?**
> Si le prix d'un produit change demain, les anciennes commandes doivent conserver le prix au moment de l'achat. Sans duplication, l'historique comptable serait faussé. → Slide 15

**C'est quoi la différence entre `ManyToMany` automatique et `CommandeProduit` ?**
> ManyToMany automatique (favoris) : Doctrine gère la table de jointure, pas de colonne supplémentaire. ManyToMany avec payload (CommandeProduit) : j'ai besoin de stocker `quantite` et `prixUnitaire` sur la relation — impossible avec une jointure automatique, donc j'en fais une entité à part entière. → Slide 15

**Pourquoi le panier n'est pas en base de données ?**
> Parce qu'un tableau `[produitId => quantite]` en session suffit. Stocker en base chaque ajout au panier générerait des écritures constantes pour un état temporaire. → Slide 15

**C'est quoi le problème N+1 que tu as évité dans `getLignes()` ?**
> Si je faisais `findById($id)` dans une boucle, j'aurais une requête SQL par produit. Avec `findBy(['id' => array_keys($panier)])`, j'ai une seule requête pour tous les produits. → Slide 25

**Pourquoi utiliser des enums PHP plutôt que des constantes de classe ?**
> L'IDE autocompète, il est impossible de stocker une valeur hors de l'enum, et Doctrine les sérialise proprement. Une constante de classe `const STATUS_EN_ATTENTE = 'en_attente'` ne garantit rien — on peut passer n'importe quelle string à la place. → Slide 15

---

## Sécurité

**C'est quoi une attaque CSRF et comment tu t'en protèges ?**
> Un site malveillant soumet un formulaire à la place de l'utilisateur connecté. Protection : un token unique lié à la session est inclus dans chaque formulaire et vérifié à la soumission. Symfony le gère automatiquement. → Slide 22

**Pourquoi les messages d'erreur de connexion sont vagues ?**
> Si on dit "email introuvable", un attaquant peut tester des emails pour savoir quels comptes existent — c'est de l'énumération de comptes. "Email ou mot de passe incorrect" ne donne aucune information. Recommandation OWASP. → Slide 21

**Comment Symfony hash les mots de passe ?**
> Algorithme `auto` — Symfony choisit le meilleur selon la version PHP. Sur PHP 8.3 avec l'extension sodium disponible, c'est Sodium (argon2id). Les mots de passe en clair ne sont jamais stockés ni loggés. → Slide 22

**Twig protège contre le XSS — comment ?**
> Toutes les variables affichées avec `{{ }}` sont échappées automatiquement. `<script>` devient `&lt;script&gt;`. Il faut explicitement utiliser `|raw` pour afficher du HTML non échappé — et c'est intentionnel. → Slide 22

**Comment tu vérifies que le webhook vient bien de Stripe et pas d'un attaquant ?**
> Stripe signe chaque requête avec un algorithme HMAC et une clé secrète partagée. `Webhook::constructEvent()` recalcule la signature et la compare. Si ça ne correspond pas → HTTP 400, requête rejetée. → Slide 23

---

## Paiement & Webhook

**Pourquoi utiliser un webhook plutôt que de confirmer la commande au retour navigateur ?**
> Si l'utilisateur ferme la fenêtre après avoir payé, le retour navigateur n'arrive jamais. Le webhook est un appel serveur-à-serveur, indépendant du navigateur — fiable même si l'utilisateur déconnecte. → Slide 18

**C'est quoi l'idempotence et pourquoi c'est important ici ?**
> Stripe peut envoyer le même événement plusieurs fois (retry si pas de réponse 200). Sans protection, la commande serait confirmée deux fois et l'email envoyé deux fois. Je vérifie le statut avant d'agir : si déjà "confirmée", on ne fait rien mais on répond 200. → Slide 23

**Tu ne stockes pas les données de carte — comment tu fais alors pour le paiement ?**
> L'utilisateur saisit sa carte directement sur les serveurs de Stripe (Stripe Checkout). Mon serveur ne voit jamais les données bancaires. Stripe me notifie via webhook que le paiement est confirmé. → Slide 18

---

## Frontend & JavaScript

**C'est quoi Stimulus et pourquoi tu l'as choisi ?**
> Stimulus connecte des attributs HTML (`data-controller`, `data-action`, `data-target`) à des classes JavaScript. Pas de DOM virtuel, pas de compilation. Il s'ajoute par-dessus du HTML existant — parfait avec Twig qui génère le HTML côté serveur. → Slide 10

**Comment fonctionne le mode infini du carousel ?**
> Je clone les N premiers éléments et les place à la fin, et les N derniers que je place au début. Quand l'utilisateur arrive sur un clone, je désactive la transition CSS (durée à 0ms), je saute sur le vrai élément correspondant, et je réactive la transition — l'utilisateur ne voit rien. → Slide 14

**Pourquoi `inert` plutôt que `aria-hidden` sur les slides inactifs ?**
> `aria-hidden` masque aux lecteurs d'écran mais ne bloque pas le focus clavier. Un utilisateur peut toujours tabber vers un bouton dans un slide caché. `inert` désactive simultanément le focus, les événements pointer, et masque aux lecteurs d'écran — une seule propriété pour tout. → Slide 14

**C'est quoi un Live Component et en quoi c'est différent d'un appel fetch classique ?**
> Un Live Component est un composant Twig qui se re-rend côté serveur via AJAX quand son état change. La différence : je n'écris pas de JavaScript pour faire l'appel ni pour mettre à jour le DOM — Symfony UX gère tout. J'écris juste du PHP et du Twig. → Slide 21

**Comment les controllers Stimulus communiquent entre eux (exemple favoris) ?**
> Via le DOM : `this.element.closest('[data-controller~="flash-tooltip"]')` remonte dans le DOM pour trouver l'élément qui a le controller `flash-tooltip`, puis appelle sa méthode `show()`. Pas d'import, pas de bus d'événements. → Slide 24

**C'est quoi `activeValueChanged()` — pourquoi tu n'appelles pas la méthode toi-même ?**
> C'est le Values API de Stimulus. Quand je définis une `value` dans le controller, Stimulus génère automatiquement un callback `[name]ValueChanged()` appelé à chaque changement. Je fais `this.activeValue = data.favori` et Stimulus appelle la méthode pour moi. → Slide 24

---

## Atomic Design & Composants Twig

**C'est quoi l'avantage d'Atomic Design concrètement ?**
> Si je change la couleur du bouton primary dans `Button.html.twig`, tous les boutons primary du site se mettent à jour — sans chercher chaque endroit où le bouton est utilisé. Un seul point de vérité. → Slide 12

**Pourquoi `"ghost-danger"` a des guillemets dans la map Twig ?**
> En Twig, le tiret `-` est l'opérateur de soustraction. Sans guillemets, `ghost-danger` serait interprété comme `ghost` moins `danger`. Les guillemets font de la clé une chaîne littérale. → Slide 13

**C'est quoi `attributes.defaults()` dans Button.html.twig ?**
> Ça fusionne les attributs passés au composant avec les attributs par défaut (la classe CSS calculée). Si l'appelant passe une classe supplémentaire, elle s'ajoute au lieu d'écraser. Si il ne passe rien, le défaut s'applique. → Slide 13

---

## Tests

**C'est quoi la différence entre un test unitaire et un test fonctionnel chez toi ?**
> Unitaire : teste une classe isolée, sans HTTP, sans base de données — par exemple `PanierService`. Fonctionnel : simule une vraie requête HTTP vers le kernel Symfony, avec la base de test. → Slide 26

**Pourquoi tu as une base de données séparée pour les tests ?**
> Pour ne pas polluer les données de développement et pouvoir réinitialiser l'état entre chaque test sans affecter la dev. → Slide 26

**C'est quoi le problème du token CSRF dans les tests que tu as corrigé ?**
> Le test envoyait un POST directement sans token → Symfony rejetait la requête et redirigeait vers `/connexion`. Correction : faire d'abord un GET pour récupérer le vrai token depuis le formulaire, puis le soumettre avec le POST. Exactement ce que fait un vrai navigateur. → Slide 26

---

## Déploiement

**Pourquoi Docker en développement ?**
> N'importe qui peut cloner le projet et lancer `docker compose up` sans installer PHP, MySQL ou nginx sur sa machine. L'environnement est identique pour tout le monde. → Slide 27

**Comment tu gères les variables sensibles (clés Stripe, mot de passe BDD) ?**
> Elles sont stockées dans Railway (variables d'environnement de la plateforme), jamais dans le code ni dans Git. En local, dans un fichier `.env.local` qui est dans `.gitignore`. → Slide 27

**Pourquoi les emails SMTP ne marchaient pas sur Railway ?**
> Railway bloque les connexions sortantes sur les ports email (25, 465, 587) pour éviter que la plateforme soit utilisée pour du spam. Resend utilise HTTPS — ça contourne le problème. → Slide 30

**Comment tu testes le webhook Stripe en local si Stripe ne peut pas appeler localhost ?**
> Stripe CLI avec `stripe listen --forward-to localhost:8080/webhook/stripe`. Il crée un tunnel et relaie les événements Stripe vers ma machine locale. → Slide 30

---

## Questions ouvertes (pas de réponse unique)

- "Si tu refaisais le projet, tu changerais quoi dans la modélisation de la base de données ?"
- "Tu aurais pu utiliser React ou Vue.js — pourquoi tu as choisi Stimulus ?"
- "C'est quoi le risque principal de sécurité que tu n'as pas encore traité ?"
  > Réponse honnête : token CSRF sur les actions AJAX (favoris) — je l'ai identifié moi-même dans les améliorations futures.
- "EasyAdmin c'est pas un peu de la triche pour l'admin ?"
  > Non — l'admin est un outil interne, pas une fonctionnalité utilisateur. Réimplémenter un CRUD admin from scratch n'apporte aucune valeur métier. EasyAdmin est configuré et personnalisé, pas juste branché.
- "Pourquoi Tailwind et pas du CSS classique ou Bootstrap ?"
  > Tailwind v4 : les tokens CSS sont des custom properties natives, utilisables partout sans JavaScript. Pas de fichier de config JS. Les classes utilitaires évitent de nommer chaque chose — on nomme les composants, pas les styles.
