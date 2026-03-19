# templates/ — Vues Twig (HTML)

Contient tous les fichiers HTML du projet, écrits en Twig (langage de templates).

---

## Structure

```
templates/
├── base.html.twig          # Template de base : balises <html>, <head>, <body>
│                           # Toutes les autres pages en héritent via {% extends %}
│
├── home/                   # Page d'accueil (/)
├── produits/               # Page produits (/produits)
├── recettes/               # Page recettes (/recettes)
├── contact/                # Page contact (/contact)
├── panier/                 # Page panier (/panier)
├── commande/               # Pages commande (récap, succès, annulation)
├── compte/                 # Espace client (/mon-compte)
├── security/               # Connexion, inscription, confirmation email
├── admin/                  # Panel admin (dashboard, calendrier)
│
├── components/             # Composants Twig réutilisables (Atomic Design)
│   ├── atoms/              # Éléments de base (Button, Input, Icon...)
│   ├── molecules/          # Combinaisons d'atoms (FormField, DessertCard...)
│   └── organisms/          # Blocs complets (Header, Footer, PanierLive...)
│
├── emails/                 # Templates des emails envoyés aux utilisateurs
└── pdf/                    # Template de la facture PDF
```

---

## Comment fonctionne l'héritage Twig

Toutes les pages héritent de `base.html.twig` :

```twig
{# Dans home/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Accueil{% endblock %}

{% block body %}
  {# Contenu spécifique à la page #}
{% endblock %}
```

`base.html.twig` définit les blocs (`title`, `body`, `stylesheets`, `javascripts`) que les pages peuvent remplir.

---

## Comment utiliser un composant

```twig
{# Appel d'un composant Atom #}
<twig:Atoms:Button variant="primary">Commander</twig:Atoms:Button>

{# Appel d'un composant Molecule avec props #}
<twig:Molecules:DessertCard :produit="produit" />

{# Appel d'un Organism #}
<twig:Organisms:Header />
```

---

## Emails

Les templates d'emails sont dans `emails/` et sont rendus par `MailerService` :

| Template | Envoyé quand |
|----------|-------------|
| `confirmation_inscription.html.twig` | Après inscription — contient le lien de vérification |
| `bienvenue.html.twig` | Après confirmation de l'email |
| `confirmation_commande.html.twig` | Après paiement Stripe — avec facture PDF en pièce jointe |
| `annulation_commande.html.twig` | Quand l'utilisateur annule une commande |
