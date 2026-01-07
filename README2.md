Contexte projet : e-commerce Symfony.
Stack UI : Symfony UX Twig Components + Twig + Tailwind CSS.
Exigences :
- Toujours intégrer l’accessibilité (a11y) : labels, aria-*, roles, navigation clavier, contrastes, etc.
- Pour chaque composant que je demande : donne-moi
  1) la ligne de commande Symfony Maker pour le générer (php bin/console make:twig-component ...),
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