# Présentation Soutenance — SamyDessert
**Samy Ben Hamida — 2026**

---

## Slide 1 — Titre

**SamyDessert**
Boutique en ligne de pâtisseries artisanales

> Samy Ben Hamida
> Développeur Web — Formation  DWWM AUXILIA 2024-2026


---

## Slide 2 — Sommaire

1. Contexte & Analyse des besoins
2. Design & Identité visuelle
3. Stack & Architecture technique
4. Fonctionnalités
5. Qualité & Sécurité
6. Déploiement & Organisation
7. Bilan & Perspectives

---

## Slide 3 — Présentation personnelle & projet

**Samy Ben Hamida — 34 ans**

- Formation **Développeur Web et Web Mobile** (RNCP Niveau 5) — ESRP Auxilia, alternance
- Stage chez **Creative Handicap** — association qui rend le numérique accessible à tous

**SamyDessert — pourquoi ce projet ?**

> Passionné de pâtisserie, je partage régulièrement mes desserts avec mes collègues. J'ai voulu allier cette passion à ma formation en créant une plateforme hybride : recettes gratuites + boutique en ligne.

*[insérer capture accueil.png — page principale du site]*

---

## Slide 4 — Benchmark & Inspiration

**Analyse de sites concurrents avant de commencer**


Points retenus :
- Mise en avant visuelle des produits (grandes photos)
- Navigation claire par catégorie
- Identité visuelle forte et cohérente

*[insérer capture Inspiration.png]*

---

## Slide 5 — Personas

**Qui sont les utilisateurs cibles ?**

*[insérer captures personna1.png + personna2.png]*


---

## Slide 6 — User Flow

**Parcours utilisateur principal**

Accueil → Catalogue → Fiche produit → Panier → Commande → Paiement → Email de confirmation

*[insérer capture userFlow.png]*

---

## Slide 7 — Wireframe

**Maquettes basse fidélité réalisées avant le développement**

Permet de valider la structure des pages avant de coder :
- Disposition des éléments
- Navigation
- Hiérarchie de l'information

*[insérer capture wireframeLow.png]*

---

## Slide 8 — Identité visuelle & Design system

**Logo** — "S" stylisé, conçu avec Affinity Designer *[Logo.png]*

**Palette de couleurs — tokens CSS dans `app.css` :**
- Chocolat `#3B1F0E` — textes, fonds sombres
- Framboise `#C0392B` — CTA, accents
- Pistache `#7BAE7F` — badges, succès
- Crème `#FDF6EC` — fond principal

*[insérer capture token.png]*

**Composants réutilisables :**
- **Atoms** : bouton, badge, input
- **Molecules** : input + label
- **Organisms** : header, footer

*[insérer captures Button.png + InputField.png]*

---

## Slide 9 — Responsive Design & Accessibilité

**Mobile-first avec Tailwind CSS v4**

3 breakpoints testés : Mobile / Tablette / Desktop

Accessibilité :
- Contraste vérifié (Colorable) — conformité WCAG
- Police Luciole (dyslexie)
- Focus visible sur tous les éléments interactifs

*[insérer captures grilleProduitMobile.png + grilleProduitTablette.png + grilleProduitDesktop.png + contrastColorable.png]*

---

## Slide 10 — Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | PHP 8.3 + Symfony 7.4 |
| Frontend | Twig + Tailwind CSS v4 + Stimulus |
| Temps réel | Symfony UX Live Components (Turbo) |
| Base de données | MySQL 8.0 + Doctrine ORM |
| Paiement | Stripe (Checkout + Webhooks) |
| Emails | Resend API |
| Déploiement | Docker + Railway |
| Assets | AssetMapper + ImportMap |

---

## Slide 11 — Architecture MVC

**Pattern : MVC (Model View Controller)**

- **Models** : entités Doctrine (`Produit`, `Commande`, `Utilisateur`...)
- **Views** : templates Twig + composants atomiques
- **Controllers** : logique métier légère, délèguent aux Services
- **Services** : logique métier (`PanierService`, `MailerService`, `FactureService`)

*[insérer capture MVC.png]*

---

## Slide 12 — Structure du projet

**Architecture Atomic Design**

Les composants UI sont organisés du plus simple au plus complexe :
- **Atoms** : bouton, lien, badge, input
- **Molecules** : carte produit, bouton panier, notation étoiles
- **Organisms** : header, footer, grille produits, panier live

**14 controllers Stimulus** — interactions côté client :

`carousel` · `cart-sidebar` · `favori` · `dropdown` · `confirm` · `nav-toggle` · `image-zoom` · `star-rating` · `annulation` · `password-toggle` · `flash-tooltip` · `consent-banner` · `csrf-protection` · `submit-once`

*[insérer captures arborescenceProjet.png + atomicDesignFichiers.png]*

---

## Slide 13 — Code : Atomic Design — Atom & Molécule

**Atom — Button.html.twig**

```twig
{% set variants = {
  primary:      "bg-accent text-white hover:bg-primary hover:scale-105",
  ghost:        "bg-transparent text-text hover:bg-surface hover:scale-105",
  danger:       "bg-danger text-white hover:bg-danger-dark hover:scale-105",
  "ghost-danger": "text-danger border-2 border-danger hover:bg-danger hover:text-white",
} %}
<button type="{{ type }}"
  {{ attributes.defaults({
    class: base ~ ' ' ~ (variants[variant] ?? variants.primary)
  }) }}
>
  {% block content %}{% endblock %}
</button>
```

```twig
<twig:Atoms:Button>Commander</twig:Atoms:Button>
<twig:Atoms:Button variant="ghost">Annuler</twig:Atoms:Button>
```

**Molécule — InputField.html.twig**

```twig
<twig:Atoms:Label for="{{ id }}" label="{{ label }}" :required="required" />
<twig:Atoms:Input
  id="{{ id }}" name="{{ name }}" type="{{ type }}"
  aria-invalid="{{ isInvalid ? 'true' : 'false' }}"
  aria-describedby="{{ describedBy }}"
/>
{% if error %}
  <p id="{{ this.errorId }}" role="alert" class="text-danger">
    {{ error }}
  </p>
{% endif %}
```

```twig
<twig:Molecules:InputField name="email" label="Email" type="email" :required="true" />
```

---

## Slide 14 — Code : Controller Stimulus — Carousel

**Mode infini — clonage + saut silencieux**

```js
this.items = [
  ...this.items.slice(this.items.length - this.offset).map(i => i.cloneNode(true)),
  ...this.items,
  ...this.items.slice(0, this.offset).map(i => i.cloneNode(true)),
];
```

```js
onTransitionEnd() {
  if (this.currentItem <= this.offset) {
    this.setTransition(false);
    this.currentItem += this.items.length - 2 * this.offset;
    this.translate();
  } else if (this.currentItem >= this.items.length - this.offset) {
    this.setTransition(false);
    this.currentItem -= this.items.length - 2 * this.offset;
    this.translate();
  }
}
```

**Protection contre le double-clic — `isAnimating`**

```js
next() {
  if (this.isAnimating) return;
  this.isAnimating = true;
  this.gotoItem(this.currentItem + this.slidesToScroll);
  setTimeout(() => { this.isAnimating = false; }, this.options.transitionDuration);
}
```

**Accessibilité — attribut `inert` sur les slides hors champ**

```js
setActiveItems() {
  this.items.forEach((item, i) => {
    const isActive = i >= this.currentItem && i < this.currentItem + this.slidesVisible;
    item.inert = !isActive;
    item.setAttribute('aria-hidden', String(!isActive));
  });
}
```

---

## Slide 15 — Base de données

**6 entités :**

`Utilisateur` · `Produit` · `Catégorie` · `Recette` · `Commande` · `Avis`

**1 table de liaison enrichie :** `CommandeProduit` (quantité + prix unitaire)

**Panier :** géré en session via `PanierService` — pas d'entité en base

**Favoris :** relation `ManyToMany` sur `Utilisateur` — 2 tables de jointure automatiques Doctrine

Points clés :
- Prix en `DECIMAL(8,2)` — pas de float (erreurs d'arrondi)
- Prix dupliqué dans `CommandeProduit` — historique fiable
- Enums PHP natifs (`StatutCommande`, `Difficulté`)

*[insérer capture DBdiagram.png]*

---

## Slide 16 — Fonctionnalités : Catalogue & Recettes

**Catalogue produits**
- Filtres par catégorie, tri par prix/note
- Turbo Frames — navigation sans rechargement
- Zoom image au clic
- Système de favoris (AJAX)

**Section recettes**
- Même organism que le catalogue produits — recettes gratuites, même expérience

*[insérer captures grilleProduitDesktop.png + ReccetteGrid.png]*

---

## Slide 17 — Fonctionnalités : Panier

**Sidebar panier persistante**
- Ouverture/fermeture via Stimulus
- Mise à jour en temps réel (Live Component)
- Ajout / retrait / suppression de produits
- Confirmation avant vidage (dialog natif HTML)

*[insérer captures modalPanier.png + ConfirmationViderPanier.png]*

---

## Slide 18 — Fonctionnalités : Commande & Paiement

**Tunnel de commande**
1. Récapitulatif panier
2. Redirection vers Stripe Checkout
3. Webhook Stripe → mise à jour statut commande
4. Email de confirmation + facture PDF

*[insérer capture stripeCheckout.png]*

---

## Slide 19 — Fonctionnalités : Emails transactionnels

**4 emails automatiques :**

| Déclencheur | Email envoyé |
|-------------|-------------|
| Inscription | Lien de vérification |
| Compte vérifié | Email de bienvenue |
| Commande confirmée | Confirmation + facture PDF |
| Commande annulée | Notification d'annulation |

**Service :** Resend API — domaine `samydessert.fr` acheté et vérifié via DNS

---

## Slide 20 — Fonctionnalités : Administration

**Interface EasyAdmin**
- Gestion produits, recettes, commandes, utilisateurs, avis
- Upload d'images via VichUploader (stockage local)
- Accès réservé `ROLE_ADMIN`

**Système d'avis**
- Note 1-5 étoiles, note moyenne calculée dynamiquement
- Un seul avis par utilisateur par produit

*[insérer captures adminListeProduits.png + adminEditionProduit.png]*

---

## Slide 21 — Soins UX

- Messages d'erreur volontairement vagues sur le formulaire de connexion (recommandation OWASP)
- Bouton panier — Live Component : spinner pendant l'action, mise à jour immédiate

*[insérer capture ConnexionErreur.png]*

```php
#[AsLiveComponent]
final class BoutonPanier
{
    #[LiveProp]
    public int $produitId = 0;

    public function getQuantite(): int
    {
        return $this->panier->getQuantitePourProduit($this->produitId);
    }

    #[LiveAction]
    public function ajouter(): void
    {
        $this->panier->ajouter($this->produitId);
        $this->emit('panierUpdated');
    }
}
```

```twig
<twig:Atoms:Icon name="cart-plus" data-loading="hide" />
<twig:Atoms:Spinner data-loading="show" />
```

---

## Slide 22 — Sécurité

| Menace | Protection |
|--------|-----------|
| CSRF | Token Symfony sur tous les formulaires |
| XSS | Échappement automatique Twig |
| Injection SQL | Doctrine ORM (requêtes préparées) |
| Accès non autorisé | `ROLE_ADMIN` / `ROLE_USER` + `access_control` |
| Mots de passe | Hachage automatique Symfony (`auto`) — Sodium/bcrypt |
| Données de paiement | Jamais stockées — délégation à Stripe |

*[insérer capture securiteYaml.png]*

---

## Slide 23 — Code : Webhook Stripe & idempotence

**1 — Vérification de signature**

```php
try {
    $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
} catch (\UnexpectedValueException $e) {
    return new Response('Invalid payload', 400);
} catch (SignatureVerificationException $e) {
    return new Response('Invalid signature', 400);
}
```

**2 — Idempotence : vérifier le statut avant d'agir**

```php
if ($event->type === 'checkout.session.completed') {
    $commande = $this->commandeRepo->findOneByStripeSessionId($stripeSession->id);

    if ($commande && $commande->getStatut() === StatutCommande::EnAttente) {
        $commande->setStatut(StatutCommande::Confirmee);
        $this->em->flush();
        $this->mailer->envoyerConfirmationCommande($commande);
    }
}

return new Response('OK', 200);
```

---

## Slide 24 — Code : Favoris AJAX — Stimulus ↔ PHP

**PHP — une route pour l'ajout ET le retrait**

```php
#[Route('/favori/{type}/{id}', methods: ['POST'])]
public function toggle(string $type, int $id, EntityManagerInterface $em): JsonResponse
{
    if ($user->getProduitsFavoris()->contains($entity)) {
        $user->removeProduitFavori($entity);
        $favori = false;
    } else {
        $user->addProduitFavori($entity);
        $favori = true;
    }
    $em->flush();
    return $this->json(['favori' => $favori]);
}
```

**JS — fetch + communication entre controllers Stimulus**

```js
async toggle(e) {
    e.preventDefault();
    const response = await fetch(this.urlValue, { method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (response.status === 401) {
        this.element.closest('[data-controller~="flash-tooltip"]')
            ?.__stimulus_flash_tooltip?.show();
        return;
    }
    const data = await response.json();
    this.activeValue = data.favori;
}
```

---

## Slide 25 — Code : PanierService — Service & accès aux données

**Le Controller ne fait que déléguer — toute la logique est dans le Service**

```php
public function getLignes(): array
{
    $panier = $this->getPanierSession();
    $produits = $this->produitRepository->findBy(['id' => array_keys($panier)]);
    foreach ($produits as $produit) {
        $lignes[] = ['produit' => $produit, 'quantite' => $panier[$produit->getId()]];
    }
    return $lignes;
}

public function ajouter(int $produitId): void
{
    $panier = $this->getPanierSession();
    $panier[$produitId] = ($panier[$produitId] ?? 0) + 1;
    $this->savePanier($panier);
}

public function getTotal(): float
{
    return array_reduce($this->getLignes(), fn($total, $ligne) =>
        $total + $ligne['produit']->getPrix() * $ligne['quantite'], 0.0
    );
}
```

---

## Slide 26 — Tests

**PHPUnit 12 — 74 tests, 0 erreurs**

| Type | Nombre | Ce qui est testé |
|------|--------|-----------------|
| Unitaires | 26 | Logique métier isolée — panier, commande, emails, accès compte |
| Fonctionnels | 48 | Requêtes HTTP réelles — routes, formulaires, AJAX |

Base de test isolée (`samydessert_test`), réinitialisée entre chaque test

**Exemple : test corrigé — token CSRF manquant**

```php
// Avant : le test ne soumettait pas de token → redirection vers /connexion
$client->request('POST', '/contact', [...]);

// Après : on récupère le vrai token depuis le formulaire
$client->request('GET', '/contact');
$token = $client->getCrawler()->filter('input[name="_token"]')->attr('value');
$client->request('POST', '/contact', [..., '_token' => $token]);
$this->assertResponseRedirects('/contact');
```

*[insérer capture PHPunit.png]*

---

## Slide 27 — Déploiement

**Environnement de développement**
- Docker Compose — 6 services (nginx, php-fpm, mysql, adminer, init, assets)
- Pas d'installation locale requise

**Production — Railway**
- Déploiement automatique sur push `main`
- 1 container Docker (Dockerfile à la racine)
- Variables sensibles dans Railway (jamais commitées)
- URL : `https://samydessert-production.up.railway.app`

---

## Slide 28 — Gestion de version avec Git

**Stratégie de branches**

| Branche | Rôle |
|---------|------|
| `dev` | Développement — isolation des changements en cours |
| `main` | Code stable → déploiement Railway automatique |

**Convention de commits :** Conventional Commits
- `feat:` nouvelle fonctionnalité
- `fix:` correction de bug
- `docs:` documentation
- `refactor:` refactoring

---

## Slide 29 — Veille technologique

**Comment je me tiens informé**

- Stack Overflow, GitHub Issues — résolution de problèmes concrets
- YouTube (Grafikart, Symfony Online Conference) — démonstrations visuelles
- **IA (Claude, ChatGPT)** — compréhension rapide, vérification des réponses

**Technologies récentes adoptées dans ce projet**

| Technologie | Nouveauté |
|-------------|-----------|
| Symfony 7.4 | Live Components, UX Twig Components |
| Tailwind CSS v4 | Tokens CSS natifs, pas de `tailwind.config.js` |
| PHP 8.3 | Enums natifs, readonly properties |
| Resend API | Alternative moderne à SMTP pour les emails en prod |
| AssetMapper | Remplace Webpack Encore — zéro configuration |

---

## Slide 30 — Difficultés rencontrées

| Difficulté | Solution |
|------------|---------|
| Webhook Stripe en local | Stripe CLI (`stripe listen`) |
| Emails bloqués depuis Railway | Migration SMTP → Resend API (HTTP) |
| Tailwind watch sur Docker Windows | Script de recompilation toutes les 3s |
| Turbo Frames & rechargement partiel | Identification précise des frames Turbo |
| VichUploader + AssetMapper | Configuration manuelle du mapping |

---

## Slide 31 — Améliorations futures

**Fonctionnalités**
- Liaison produit ↔ recette (OneToOne — créer la recette à la création du produit)
- Ingrédients dans les recettes
- Modération des avis avant publication
- Variations de produits (taille, parfum)
- Recettes proposées par les utilisateurs

**Technique**
- Remplacer `php -S` par Nginx + PHP-FPM en prod
- Token de vérification email avec expiration
- Token CSRF sur les actions AJAX (favoris)
- Internationalisation (symfony/translation)

---

## Slide 32 — Démonstration live

**Démonstration sur le site en production**

🔗 `https://samydessert-production.up.railway.app`

Parcours prévu :
1. Accueil → catalogue → fiche produit
2. Ajout au panier → commande → paiement Stripe
3. Interface admin

> Comptes de démonstration :
> - Admin : `samy@admin.com` / `password123`
> - Utilisateur : `test@test.com` / `password123`

---

## Slide 33 — Bilan personnel

**Ce que j'ai appris**

- Structurer un projet Symfony de A à Z
- Travailler avec Docker en environnement de dev
- Intégrer des services tiers (Stripe, Resend, VichUploader)
- Utiliser l'IA comme outil d'apprentissage — poser les bonnes questions, vérifier les réponses
- Déployer en production sur Railway
- Concevoir une identité visuelle cohérente (logo, palette, design system) avec Affinity Designer et Figma
- Appliquer les principes d'accessibilité web (contraste WCAG, police Luciole, focus clavier)
- Découper un projet en tâches et responsabilités claires — chaque Controller, Service et composant a un rôle unique

**Ce qui m'a le plus apporté**
> Voir un projet passer d'une idée à un produit réel, en ligne, utilisable — et comprendre chaque brique qui le compose.

---

## Slide 34 — Questions

**Merci !**

SamyDessert — Boutique en ligne de pâtisseries artisanales


*Prêt pour vos questions*
