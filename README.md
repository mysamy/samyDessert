## Commandes utiles

symfony serve
symfony console cache:clear
composer install
symfony console tailwind:build
symfony console tailwind:build --watch
symfony local:server:stop --all
php bin/console make:twig-component "Molecules\\CheckboxField" 
php bin/console asset-map:compile

Contexte projet : e-commerce Symfony.
Stack UI : Symfony UX Twig Components + Twig + Tailwind CSS.
Exigences :
- Toujours intégrer l’accessibilité (a11y) : labels, aria-*, roles, navigation clavier, contrastes, etc.
- Pour chaque composant que je demande : donne-moi
  1) la ligne de commande Symfony Maker pour le générer (exemple : php bin/console make:twig-component Molecules\\RadioGroup),
  2) le fichier PHP complet (src/Twig/Components/...),
  3) le fichier Twig complet (templates/components/...),
  4) et dis explicitement s’il doit être : Twig Component (statique) ou Live Component (dynamique) + pourquoi (1 phrase).
Conventions :
- Atomic design : Atoms / Molecules / Organisms.
- Noms par défaut (pas de #[AsTwigComponent('...')] sauf si composant critique/ambigu).
- ligne de code exemple : "php bin/console make:twig-component Molecules\\CheckboxField" 
- Code moderne et recommandations actuelles Symfony/Twig/Tailwind.
Important : ne me donne qu’une seule proposition (pas 2 variantes).
- Sans commentaire dans le code
-

Contexte projet
Je développe un site e-commerce avec Symfony.

Stack UI

Symfony UX Twig Components

Twig

Tailwind CSS

Atomic Design : Atoms / Molecules / Organisms

Règles importantes

Toujours intégrer l’accessibilité (a11y) : labels, aria-*, roles, navigation clavier, contrastes.

Utiliser des Twig Components statiques par défaut (Live Components uniquement si interaction temps réel justifiée).

Pas de sur-abstraction : on factorise seulement quand un pattern est clairement récurrent.

Un seul block Twig par nom dans un template (pas de block dupliqué dans des if/else).

Dans les tags <twig:…> : aucun {% if %} à l’intérieur.

Si un composant utilise un slot, toujours capturer les variables avant ({% set x = this.x %}), car this change de contexte.

Les Atoms peuvent utiliser attributes.defaults(...).

Les Molecules composent les Atoms.

Les Organisms assemblent Molecules + Atoms (UI métier).

Les namespaces doivent être écrits avec double antislash : Molecules\\InputField.

Conventions composants

Pas de #[AsTwigComponent('name')] explicite sauf composant critique/ambigu.

Code moderne et recommandé Symfony/Twig/Tailwind.

Une seule proposition à chaque fois (pas de variantes).

État actuel du design system

Atoms : Button (slot, rend <a> si href sinon <button>), Input, Textarea, Label, Text, Icon, Select

Molecules : InputField, TextareaField, SelectField, CheckboxField, RadioGroup, FormFieldGroup, FormActions

Organisms : Form, RegisterForm, LoginForm, AddressForm, CartSummary, ProductCard

Objectif

Continuer uniquement sur l’UI (pas de contrôleurs Symfony pour l’instant)

Créer les prochains Organisms e-commerce (ex: ProductCardGrid, HeaderNav, CheckoutSummary)

Me guider étape par étape, avec du code complet (PHP + Twig) quand je demande un composant.

Contexte : Je développe un projet Symfony avec Symfony UX Twig Components. Architecture UI : Atomic Design (Atoms / Molecules / Organisms). Stack : Twig, Tailwind CSS, Symfony. Règles à respecter impérativement : - Composants UI uniquement (pas de logique métier). - Pas de Live Components sauf justification. - Slots : - Le slot par défaut est {% block content %}{% endblock %} dans le template du composant. - Jamais de {% block %} dans l’utilisation d’un composant. - Il n’existe pas de variable content. - Interdit : {% if %} / {% for %} dans les attributs d’un <twig:…>. → utiliser des expressions ternaires. - Gestion des classes : - Pas de this.class dans les Atoms. - Toujours attributes.defaults({ class: '...' }). - Types PHP : - Tout ce qui est rendu → string = ''. - null uniquement si l’absence change la structure HTML. - Passage de props : - prop="..." = string - :prop="variable" = expression Twig. - Capturer les props ({% set x = this.x %}) au début des templates, surtout si slot. - Navigation : - HeaderNav = Organism, Nav = Molecule. - Clé unique href pour les liens. - path() uniquement avec des noms de routes existantes. - A11y systématique (aria-label, aria-current, icônes décoratives). Objectif : Code propre, moderne, robuste, sans erreurs Twig ni dépréciations.