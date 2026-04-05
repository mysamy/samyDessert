<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Recette;
use App\Enum\Difficulte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Fixtures : insère des données de test dans la base de données
// Lancer avec : php bin/console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    // Injection du service de hashage de mot de passe
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // --- Catégories ---
        $categories = [];
        foreach ([
            'tartes'       => 'Tartes',
            'choux'        => 'Choux & Éclairs',
            'petits-fours' => 'Petits Gâteaux',
            'entremets'    => 'Gâteaux',
        ] as $slug => $nom) {
            $cat = new Categorie();
            $cat->setNom($nom);
            $cat->setSlug($slug);
            $manager->persist($cat);
            $categories[$slug] = $cat;
        }

        // --- Produits ---
        $produits = [
            // Tartes
            ['nom' => 'Tarte aux fraises',        'slug' => 'tarte-aux-fraises',        'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'tarteFraise.png',           'description' => 'Pâte sablée maison, crème pâtissière et fraises fraîches de saison.'],
            ['nom' => 'Tarte au citron meringuée', 'slug' => 'tarte-citron-meringuee',   'prix' => '7.00', 'categorie' => 'tartes',       'image' => 'tarte-citron-meringuée.jpg',     'description' => 'Tarte acidulée avec une meringue légère et croustillante.'],
            ['nom' => 'Tarte aux framboises',      'slug' => 'tarte-aux-framboises',     'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'tarte-au-framboises.jpg',        'description' => 'Fond de tarte croustillant, crème d\'amandes et framboises fraîches.'],
            ['nom' => 'Tarte tatin',               'slug' => 'tarte-tatin',              'prix' => '6.00', 'categorie' => 'tartes',       'image' => 'tarte-tatin.webp',               'description' => 'Tarte renversée aux pommes caramélisées, servie tiède avec crème fraîche.'],
            ['nom' => 'Tarte aux myrtilles',       'slug' => 'tarte-aux-myrtilles',      'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'tarte-aux-mytilles.jpg',         'description' => 'Fond sablé, crème d\'amandes et myrtilles fraîches du marché.'],
            // Choux
            ['nom' => 'Éclair au chocolat',        'slug' => 'eclair-au-chocolat',       'prix' => '4.00', 'categorie' => 'choux',        'image' => 'Éclair-au-chocolat.jpg',         'description' => 'Pâte à choux garnie d\'une crème pâtissière au chocolat noir.'],
            ['nom' => 'Paris-Brest',               'slug' => 'paris-brest',              'prix' => '5.50', 'categorie' => 'choux',        'image' => 'Paris-Brest.jpg',                'description' => 'Couronne de pâte à choux garnie d\'une crème mousseline praliné.'],
            ['nom' => 'Religieuse café',           'slug' => 'religieuse-cafe',          'prix' => '4.50', 'categorie' => 'choux',        'image' => 'religieuse.webp',                'description' => 'Double chou à la crème café, glaçage fondant.'],
            ['nom' => 'Chouquettes (x10)',         'slug' => 'chouquettes-x10',          'prix' => '3.50', 'categorie' => 'choux',        'image' => 'Chouquettes (x10).jpg',          'description' => 'Petits choux légers parsemés de sucre perlé, à croquer sans modération.'],
            ['nom' => 'Saint-Honoré',              'slug' => 'saint-honore',             'prix' => '8.00', 'categorie' => 'choux',        'image' => 'st-honore.webp',                 'description' => 'Couronne de pâte feuilletée, choux caramélisés et crème Chiboust.'],
            // Petits fours
            ['nom' => 'Macarons (x6)',             'slug' => 'macarons-x6',              'prix' => '9.00', 'categorie' => 'petits-fours', 'image' => 'macarons.png',                   'description' => '12 parfums au choix, coques croustillantes et ganaches maison.'],
            ['nom' => 'Crème brûlée',              'slug' => 'creme-brulee',             'prix' => '5.50', 'categorie' => 'petits-fours', 'image' => 'creme-brulee.jpg',               'description' => 'Crème vanille onctueuse avec une fine croûte de caramel.'],
            ['nom' => 'Mille-feuille',             'slug' => 'mille-feuille',            'prix' => '6.00', 'categorie' => 'petits-fours', 'image' => 'Mille-feuille.jpg',              'description' => 'Feuilletage croustillant, crème pâtissière vanille et glaçage royal.'],
            ['nom' => 'Financiers (x4)',           'slug' => 'financiers-x4',            'prix' => '4.50', 'categorie' => 'petits-fours', 'image' => 'financiers.webp',                'description' => 'Petits gâteaux moelleux au beurre noisette et poudre d\'amande.'],
            ['nom' => 'Madeleine au beurre (x6)',  'slug' => 'madeleine-au-beurre-x6',   'prix' => '5.00', 'categorie' => 'petits-fours', 'image' => 'madelaine-au-beurre.webp',       'description' => 'Les vraies madeleines de Commercy, moelleuses avec leur bosse caractéristique.'],
            // Entremets
            ['nom' => 'Mousse au chocolat',        'slug' => 'mousse-au-chocolat',       'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'Mousse-au-chocolat.jpg',         'description' => 'Mousse aérienne au chocolat noir, à préparer la veille pour un résultat optimal.'],
            ['nom' => 'Charlotte aux framboises',  'slug' => 'charlotte-aux-framboises',  'prix' => '7.50', 'categorie' => 'entremets',    'image' => 'charlotte-aux-framboises.webp',  'description' => 'Biscuits à la cuillère et mousse framboise, élégante et fraîche.'],
            ['nom' => 'Fondant au chocolat',       'slug' => 'fondant-au-chocolat',      'prix' => '5.50', 'categorie' => 'entremets',    'image' => 'Fondant-au-chocolat.jpg',        'description' => 'Fondant au cœur coulant, à servir tiède avec une boule de glace vanille.'],
            ['nom' => 'Tiramisu au chocolat',      'slug' => 'tiramisu',                 'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'tiramisuChocolat.png',           'description' => 'Mascarpone onctueux, biscuits imbibés et cacao amer en finition.'],
            ['nom' => 'Opéra',                     'slug' => 'opera',                    'prix' => '7.00', 'categorie' => 'entremets',    'image' => 'Opéra.jpg',                      'description' => 'Biscuit joconde, crème au beurre café et ganache chocolat en couches alternées.'],
            ['nom' => 'Cheesecake',                'slug' => 'cheesecake',               'prix' => '6.50', 'categorie' => 'entremets',    'image' => 'cheesecake.png',                 'description' => 'Base biscuitée croustillante, crème onctueuse et coulis de fruits rouges.'],
            ['nom' => 'Brownies',                  'slug' => 'brownies',                 'prix' => '4.50', 'categorie' => 'petits-fours', 'image' => 'brownies.png',                   'description' => 'Moelleux au cœur fondant, pépites de chocolat noir intense.'],
            ['nom' => 'Cookies',                   'slug' => 'cookies',                  'prix' => '4.00', 'categorie' => 'petits-fours', 'image' => 'cookie.png',                     'description' => 'Croustillants à l\'extérieur, fondants à l\'intérieur, généreux en pépites.'],
        ];

        $produitEntites = [];
        foreach ($produits as $data) {
            $produit = new Produit();
            $produit->setNom($data['nom']);
            $produit->setSlug($data['slug']);
            $produit->setPrix($data['prix']);
            $produit->setDescription($data['description']);
            $produit->setImageName($data['image']);
            $produit->setDisponible(true);
            $produit->setCategorie($categories[$data['categorie']]);
            $manager->persist($produit);
            $produitEntites[$data['nom']] = $produit;
        }

        // --- Recettes ---
        $recettes = [
            [
                'titre'      => 'Tarte au citron meringuée',
                'slug'       => 'tarte-citron-meringuee',
                'description'=> 'Une tarte acidulée avec une meringue légère et croustillante, parfaite pour les amateurs de citron.',
                'contenu'    => "Préparer la pâte sablée et la cuire à blanc 15 min à 180 °C.\nRéaliser le lemon curd : fouetter 3 œufs, 150 g de sucre, le jus de 4 citrons et 80 g de beurre au bain-marie jusqu'à épaississement.\nVerser le lemon curd sur le fond de tarte refroidi et lisser à la spatule.\nMonter 3 blancs d'œufs en neige ferme avec 150 g de sucre pour obtenir une meringue brillante.\nPocher la meringue sur la tarte en formant des pics à la poche à douille.\nDorer au chalumeau ou sous le grill 2 min et réserver au frais 2 h avant de servir.",
                'duree'      => 90,
                'difficulte' => Difficulte::Moyen,
                'portions'   => 8,
                'categorie'  => 'tartes',
                'image'      => 'tarte-citron-meringuée.jpg',
                'produit'    => 'Tarte au citron meringuée',
            ],
            [
                'titre'      => 'Éclair au chocolat',
                'slug'       => 'eclair-au-chocolat',
                'description'=> 'La pâte à choux maison garnie d\'une crème pâtissière au chocolat noir.',
                'contenu'    => "Préparer la pâte à choux : porter 25 cl d'eau et 100 g de beurre à ébullition, ajouter 150 g de farine d'un coup et dessécher.\nIncorporer 4 œufs un par un hors du feu jusqu'à obtenir une pâte lisse et brillante.\nPocher des boudins de 12 cm sur une plaque et cuire 25 min à 180 °C sans ouvrir le four.\nRéaliser la crème pâtissière : chauffer 50 cl de lait, fouetter 4 jaunes avec 100 g de sucre et 40 g de maïzena, cuire jusqu'à épaississement puis ajouter 150 g de chocolat noir haché.\nGarnir les éclairs refroidis à l'aide d'une poche à douille par le dessous.\nPréparer le glaçage : fondre 100 g de chocolat avec 20 g de beurre, napper le dessus de chaque éclair et laisser figer.",
                'duree'      => 120,
                'difficulte' => Difficulte::Difficile,
                'portions'   => 12,
                'categorie'  => 'choux',
                'image'      => 'Éclair-au-chocolat.jpg',
                'produit'    => 'Éclair au chocolat',
            ],
            [
                'titre'      => 'Macarons à la framboise',
                'slug'       => 'macarons-framboise',
                'description'=> 'Des coques légères et croquantes garnies d\'une ganache framboise acidulée.',
                'contenu'    => "Tamiser 150 g de poudre d'amande et 150 g de sucre glace ensemble, deux fois pour un résultat fin.\nPréparer la meringue italienne : cuire 150 g de sucre avec 40 ml d'eau à 118 °C, verser en filet sur 55 g de blancs montés en neige.\nMacaronner : incorporer le tant-pour-tant aux blancs restants (55 g), ajouter la meringue et mélanger jusqu'à obtenir un ruban souple.\nPocher des disques réguliers de 3 cm sur plaque et laisser croûter 30 min à l'air libre.\nCuire 13 min à 150 °C, laisser refroidir sur la plaque avant de décoller.\nGarnir de ganache framboise (150 g chocolat blanc + 80 g purée de framboise) et assembler les coques deux par deux.",
                'duree'      => 150,
                'difficulte' => Difficulte::Difficile,
                'portions'   => 20,
                'categorie'  => 'petits-fours',
                'image'      => 'macarons.png',
                'produit'    => 'Macarons (x6)',
            ],
            [
                'titre'      => 'Tarte aux fraises',
                'slug'       => 'tarte-aux-fraises',
                'description'=> 'Une tarte fraîche avec une crème pâtissière vanille et des fraises de saison.',
                'contenu'    => "Préparer la pâte sablée : sabler 250 g de farine avec 125 g de beurre froid, ajouter 80 g de sucre glace et 1 œuf.\nÉtaler dans un moule beurré et cuire à blanc 15 min à 180 °C avec des billes de cuisson.\nRéaliser la crème pâtissière vanille : chauffer 50 cl de lait avec une gousse fendue, fouetter 4 jaunes + 80 g sucre + 40 g maïzena et cuire.\nÉtaler la crème refroidie sur le fond de tarte en couche uniforme.\nDisposer les fraises lavées et équeutées en rosace serrée sur la crème.\nNapper de gelée de fraise tiède au pinceau pour la brillance et servir frais.",
                'duree'      => 60,
                'difficulte' => Difficulte::Facile,
                'portions'   => 8,
                'categorie'  => 'tartes',
                'image'      => 'tarte-au-fraises.jpg',
                'produit'    => 'Tarte aux fraises',
            ],
            [
                'titre'      => 'Mousse au chocolat',
                'slug'       => 'mousse-au-chocolat',
                'description'=> 'Une mousse aérienne et intense au chocolat noir, à préparer la veille.',
                'contenu'    => "Faire fondre 200 g de chocolat noir 70 % au bain-marie avec 30 g de beurre, laisser tiédir.\nSéparer 6 œufs : mélanger les jaunes un à un dans le chocolat fondu.\nMonter les blancs en neige très ferme avec une pincée de sel.\nIncorporer délicatement un tiers des blancs au chocolat pour détendre, puis le reste en soulevant la masse.\nRépartir dans des verrines ou un grand saladier et filmer au contact.\nRéfrigérer au minimum 4 h (idéalement une nuit) avant de servir.",
                'duree'      => 30,
                'difficulte' => Difficulte::Facile,
                'portions'   => 6,
                'categorie'  => 'entremets',
                'image'      => 'Mousse-au-chocolat.jpg',
                'produit'    => 'Mousse au chocolat',
            ],
            [
                'titre'      => 'Fondant au chocolat',
                'slug'       => 'fondant-au-chocolat',
                'description'=> 'Le fondant au cœur coulant, à servir tiède avec une boule de glace vanille.',
                'contenu'    => "Préchauffer le four à 200 °C et beurrer 6 ramequins individuels.\nFaire fondre 200 g de chocolat noir avec 100 g de beurre au micro-ondes ou au bain-marie.\nFouetter 3 œufs entiers + 3 jaunes avec 80 g de sucre jusqu'à blanchiment.\nVerser le chocolat fondu sur les œufs et mélanger, ajouter 50 g de farine tamisée.\nRépartir dans les ramequins (les remplir aux trois quarts) et enfourner 10 à 12 min.\nDémouler immédiatement sur assiette — le cœur doit être coulant — et servir avec une boule de glace vanille.",
                'duree'      => 45,
                'difficulte' => Difficulte::Facile,
                'portions'   => 6,
                'categorie'  => 'entremets',
                'image'      => 'Fondant-au-chocolat.jpg',
                'produit'    => 'Fondant au chocolat',
            ],
            [
                'titre'      => 'Charlotte aux framboises',
                'slug'       => 'charlotte-aux-framboises',
                'description'=> 'Une charlotte classique aux biscuits à la cuillère et mousse framboise.',
                'contenu'    => "Préparer un sirop léger (100 g sucre + 10 cl eau + 2 cl kirsch) et y tremper rapidement les biscuits à la cuillère.\nChemiser un moule à charlotte avec les biscuits imbibés, côté bombé vers l'extérieur.\nPréparer la mousse : mixer 400 g de framboises, passer au tamis, ajouter 80 g de sucre.\nRamollir 4 feuilles de gélatine, les fondre dans un peu de coulis tiède et mélanger au reste.\nMonter 30 cl de crème en chantilly ferme et l'incorporer délicatement au coulis.\nVerser la mousse dans le moule, couvrir de biscuits et réfrigérer 6 h minimum avant de démouler.",
                'duree'      => 60,
                'difficulte' => Difficulte::Moyen,
                'portions'   => 10,
                'categorie'  => 'entremets',
                'image'      => 'charlotte-aux-framboises.webp',
                'produit'    => 'Charlotte aux framboises',
            ],
            [
                'titre'      => 'Paris-Brest',
                'slug'       => 'paris-brest',
                'description'=> 'La couronne de pâte à choux garnie de crème mousseline praliné.',
                'contenu'    => "Préparer la pâte à choux : porter 25 cl d'eau et 100 g de beurre à ébullition, ajouter 150 g de farine, dessécher puis incorporer 4 œufs.\nPocher une couronne de 22 cm sur plaque, parsemer d'amandes effilées et cuire 35 min à 180 °C.\nPréparer la crème pâtissière : 50 cl lait, 4 jaunes, 80 g sucre, 40 g maïzena.\nRéaliser la crème mousseline praliné : incorporer 100 g de praliné et 150 g de beurre pommade à la crème pâtissière refroidie.\nCouper la couronne en deux horizontalement et garnir généreusement de crème à la poche cannelée.\nRefermer, saupoudrer de sucre glace et servir frais.",
                'duree'      => 120,
                'difficulte' => Difficulte::Difficile,
                'portions'   => 8,
                'categorie'  => 'choux',
                'image'      => 'Paris-Brest.jpg',
                'produit'    => 'Paris-Brest',
            ],
            [
                'titre'      => 'Mille-feuille vanille',
                'slug'       => 'mille-feuille-vanille',
                'description'=> 'Feuilletage croustillant et crème pâtissière vanille, un classique indémodable.',
                'contenu'    => "Étaler la pâte feuilletée sur 3 mm, piquer et cuire entre deux plaques 20 min à 200 °C pour un feuilletage bien plat.\nDécouper 3 rectangles identiques de 10 × 30 cm dans le feuilletage doré.\nPréparer la crème pâtissière vanille : 50 cl lait infusé avec 1 gousse, 4 jaunes, 100 g sucre, 40 g maïzena.\nPocher la crème sur deux des rectangles en couche régulière de 1 cm.\nEmpiler : feuilletage, crème, feuilletage, crème, feuilletage.\nPréparer le glaçage fondant blanc, marbrer au chocolat avec une pointe de couteau et lisser. Réfrigérer 1 h.",
                'duree'      => 90,
                'difficulte' => Difficulte::Moyen,
                'portions'   => 6,
                'categorie'  => 'petits-fours',
                'image'      => 'Mille-feuille.jpg',
                'produit'    => 'Mille-feuille',
            ],
        ];

        $recettesSupp = [
            ['titre' => 'Tarte aux framboises',     'slug' => 'tarte-aux-framboises',    'description' => 'Fond de tarte croustillant, crème d\'amandes et framboises fraîches.', 'contenu' => "Préparer une pâte sablée, foncer un moule et cuire à blanc 15 min à 180 °C.\nÉtaler une couche de crème d'amandes (50 g beurre, 50 g sucre, 50 g poudre d'amande, 1 œuf) et recuire 10 min.\nLaisser refroidir, puis garnir généreusement de framboises fraîches.\nNapper d'une gelée de framboise chaude au pinceau et réfrigérer 1 h avant de servir.", 'duree' => 60, 'difficulte' => Difficulte::Facile, 'portions' => 8, 'categorie' => 'tartes', 'image' => 'tarte-au-framboises.jpg', 'produit' => 'Tarte aux framboises'],
            ['titre' => 'Tarte tatin',              'slug' => 'tarte-tatin',             'description' => 'Tarte renversée aux pommes caramélisées, servie tiède avec crème fraîche.', 'contenu' => "Éplucher 1 kg de pommes (Gala ou Reine des Reinettes), les couper en quartiers.\nFaire fondre 80 g de beurre dans une poêle allant au four, ajouter 120 g de sucre et caraméliser à feu moyen.\nDisposer les quartiers de pommes serrés dans le caramel et cuire 10 min pour les attendrir.\nCouvrir d'un disque de pâte feuilletée en rentrant les bords et enfourner 25 min à 190 °C.\nLaisser tiédir 5 min puis retourner sur un plat de service. Servir tiède avec de la crème fraîche.", 'duree' => 50, 'difficulte' => Difficulte::Facile, 'portions' => 6, 'categorie' => 'tartes', 'image' => 'tarte-tatin.webp', 'produit' => 'Tarte tatin'],
            ['titre' => 'Tarte aux myrtilles',      'slug' => 'tarte-aux-myrtilles',     'description' => 'Fond sablé, crème d\'amandes et myrtilles fraîches du marché.', 'contenu' => "Réaliser une pâte sablée, étaler dans un moule et cuire à blanc 12 min à 180 °C.\nPréparer la crème d'amandes : fouetter 60 g de beurre pommade avec 60 g de sucre, ajouter 60 g de poudre d'amande et 1 œuf.\nÉtaler la crème sur le fond de tarte et parsemer de 250 g de myrtilles fraîches.\nCuire 20 min à 170 °C jusqu'à ce que la crème soit dorée. Napper de gelée tiède et laisser refroidir.", 'duree' => 55, 'difficulte' => Difficulte::Facile, 'portions' => 8, 'categorie' => 'tartes', 'image' => 'tarte-aux-mytilles.jpg', 'produit' => 'Tarte aux myrtilles'],
            ['titre' => 'Religieuse café',          'slug' => 'religieuse-cafe',         'description' => 'Double chou à la crème café avec glaçage fondant.', 'contenu' => "Préparer la pâte à choux et pocher 6 gros choux (5 cm) et 6 petits (3 cm) sur une plaque. Cuire 25 min à 180 °C.\nRéaliser la crème pâtissière café : infuser 2 c. à soupe de café soluble dans 50 cl de lait chaud, puis cuire avec 4 jaunes, 80 g de sucre et 40 g de maïzena.\nGarnir les choux refroidis à la poche à douille fine.\nPréparer un fondant café (fondant pâtissier + café) et napper le dessus de chaque chou.\nAssembler les petits choux sur les grands avec de la crème, décorer d'une rosette.", 'duree' => 90, 'difficulte' => Difficulte::Moyen, 'portions' => 6, 'categorie' => 'choux', 'image' => 'religieuse.webp', 'produit' => 'Religieuse café'],
            ['titre' => 'Chouquettes',              'slug' => 'chouquettes',             'description' => 'Petits choux légers parsemés de sucre perlé, à croquer sans modération.', 'contenu' => "Porter 25 cl d'eau, 80 g de beurre, 1 pincée de sel et 1 pincée de sucre à ébullition.\nHors du feu, ajouter 125 g de farine d'un coup et dessécher la panade 2 min sur feu moyen.\nIncorporer 3 œufs un par un en mélangeant vigoureusement jusqu'à obtenir une pâte brillante et souple.\nPocher des petits dômes de 2 cm sur une plaque tapissée et parsemer généreusement de sucre perlé.\nCuire 20 min à 180 °C sans ouvrir le four. Laisser refroidir sur une grille avant de déguster.", 'duree' => 35, 'difficulte' => Difficulte::Facile, 'portions' => 30, 'categorie' => 'choux', 'image' => 'Chouquettes (x10).jpg', 'produit' => 'Chouquettes (x10)'],
            ['titre' => 'Saint-Honoré',             'slug' => 'saint-honore',            'description' => 'Couronne de pâte feuilletée, choux caramélisés et crème Chiboust.', 'contenu' => "Étaler un disque de pâte feuilletée de 22 cm, piquer et pocher un boudin de pâte à choux sur le pourtour. Cuire 25 min à 190 °C.\nPréparer 8 petits choux, les garnir de crème pâtissière vanille et les caraméliser un à un dans un caramel doré.\nRéaliser la crème Chiboust : crème pâtissière vanille (50 cl lait, 4 jaunes, 80 g sucre, 40 g maïzena) allégée avec une meringue italienne (4 blancs, 120 g sucre cuit).\nGarnir la couronne de crème Chiboust à la poche saint-honoré.\nDisposer les choux caramélisés sur le pourtour et servir dans les 2 heures.", 'duree' => 150, 'difficulte' => Difficulte::Difficile, 'portions' => 8, 'categorie' => 'choux', 'image' => 'st-honore.webp', 'produit' => 'Saint-Honoré'],
            ['titre' => 'Crème brûlée',             'slug' => 'creme-brulee',            'description' => 'Crème vanille onctueuse avec une fine croûte de caramel.', 'contenu' => "Préchauffer le four à 150 °C et préparer un bain-marie (plaque creuse avec eau chaude).\nFouetter 6 jaunes d'œufs avec 80 g de sucre sans faire blanchir.\nChauffer 50 cl de crème liquide entière avec 1 gousse de vanille fendue et grattée jusqu'à frémissement.\nVerser la crème chaude en filet sur les jaunes en fouettant, passer au tamis et écumer.\nRépartir dans 6 ramequins, poser dans le bain-marie et cuire 40 min — la crème doit trembler légèrement au centre.\nRéfrigérer au moins 4 h. Au moment de servir, saupoudrer de sucre roux et brûler au chalumeau.", 'duree' => 60, 'difficulte' => Difficulte::Facile, 'portions' => 6, 'categorie' => 'petits-fours', 'image' => 'creme-brulee.jpg', 'produit' => 'Crème brûlée'],
            ['titre' => 'Financiers',               'slug' => 'financiers',              'description' => 'Petits gâteaux moelleux au beurre noisette et poudre d\'amande.', 'contenu' => "Réaliser le beurre noisette : faire fondre 150 g de beurre à feu moyen jusqu'à obtenir une couleur dorée et une odeur de noisette. Filtrer et laisser tiédir.\nMélanger 180 g de sucre glace, 60 g de farine et 120 g de poudre d'amande tamisés ensemble.\nIncorporer 5 blancs d'œufs non montés au mélange sec, puis ajouter le beurre noisette tiède.\nBeurrer des moules à financiers, les remplir aux trois quarts et réfrigérer 30 min.\nCuire 12 min à 200 °C jusqu'à ce que les bords soient dorés et le centre légèrement bombé. Démouler tièdes.", 'duree' => 40, 'difficulte' => Difficulte::Facile, 'portions' => 12, 'categorie' => 'petits-fours', 'image' => 'financiers.webp', 'produit' => 'Financiers (x4)'],
            ['titre' => 'Madeleines au beurre',     'slug' => 'madeleines-au-beurre',    'description' => 'Les vraies madeleines de Commercy, moelleuses avec leur bosse caractéristique.', 'contenu' => "Fouetter 3 œufs avec 150 g de sucre jusqu'à blanchiment et consistance rubanée.\nAjouter le zeste d'un citron et 1 c. à café de miel, incorporer 200 g de farine et 1 sachet de levure tamisés.\nVerser 150 g de beurre fondu refroidi en filet et mélanger jusqu'à homogénéité.\nFilmer et réfrigérer la pâte au minimum 1 h (idéalement une nuit).\nBeurrer et fariner les moules à madeleines, remplir aux deux tiers et enfourner à 220 °C pour 5 min, puis baisser à 180 °C pour 8 min.\nLa bosse caractéristique se forme grâce au choc thermique. Démouler et déguster tièdes.", 'duree' => 30, 'difficulte' => Difficulte::Facile, 'portions' => 18, 'categorie' => 'petits-fours', 'image' => 'madelaine-au-beurre.webp', 'produit' => 'Madeleine au beurre (x6)'],
            ['titre' => 'Tiramisu au chocolat',     'slug' => 'tiramisu-au-chocolat',    'description' => 'Mascarpone onctueux, biscuits imbibés et cacao amer en finition.', 'contenu' => "Préparer un café fort (25 cl) et y dissoudre 2 c. à soupe de sucre. Laisser refroidir.\nSéparer 4 œufs. Fouetter les jaunes avec 80 g de sucre jusqu'à blanchiment.\nIncorporer 250 g de mascarpone aux jaunes sucrés en mélangeant jusqu'à consistance lisse.\nMonter les blancs en neige ferme et les incorporer délicatement au mascarpone.\nTremper rapidement les biscuits à la cuillère dans le café et disposer une couche dans un plat.\nCouvrir de crème mascarpone, saupoudrer de cacao amer tamisé et répéter l'opération.\nFilmer et réfrigérer au minimum 6 h. Saupoudrer de cacao frais au moment de servir.", 'duree' => 30, 'difficulte' => Difficulte::Facile, 'portions' => 8, 'categorie' => 'entremets', 'image' => 'tiramisuChocolat.png', 'produit' => 'Tiramisu au chocolat'],
            ['titre' => 'Opéra',                    'slug' => 'opera',                   'description' => 'Biscuit joconde, crème au beurre café et ganache chocolat en couches alternées.', 'contenu' => "Préparer le biscuit joconde : fouetter 3 œufs avec 90 g de sucre glace et 90 g de poudre d'amande, ajouter 20 g de farine, puis incorporer 3 blancs montés. Étaler en fine couche et cuire 8 min à 200 °C. Découper 3 rectangles identiques.\nRéaliser le sirop café : dissoudre 80 g de sucre dans 10 cl d'eau chaude avec 3 c. à soupe de café soluble.\nPréparer la crème au beurre café : monter 3 jaunes avec sirop de sucre cuit (120 g sucre + 4 cl eau à 118 °C), incorporer 200 g de beurre pommade et du café à votre goût.\nRéaliser la ganache : verser 15 cl de crème bouillante sur 200 g de chocolat noir haché, mélanger jusqu'à homogénéité.\nMontage : biscuit imbibé de sirop, crème au beurre, biscuit, ganache, biscuit, crème au beurre. Glacer avec la ganache restante. Réfrigérer 4 h.", 'duree' => 120, 'difficulte' => Difficulte::Difficile, 'portions' => 10, 'categorie' => 'entremets', 'image' => 'Opéra.jpg', 'produit' => 'Opéra'],
            ['titre' => 'Cheesecake',               'slug' => 'cheesecake',              'description' => 'Base biscuitée croustillante, crème onctueuse et coulis de fruits rouges.', 'contenu' => "Mixer 200 g de biscuits spéculoos en poudre fine et les mélanger avec 80 g de beurre fondu.\nTasser le mélange dans le fond d'un moule à charnière de 22 cm et réfrigérer 30 min.\nFouetter 600 g de Philadelphia à température ambiante avec 150 g de sucre jusqu'à consistance lisse.\nAjouter 3 œufs un par un, puis 20 cl de crème fraîche épaisse, le jus d'un demi-citron et 1 c. à café de vanille.\nVerser sur la base biscuitée et cuire 55 min à 160 °C en bain-marie. Éteindre le four et laisser refroidir porte entrouverte.\nRéfrigérer 8 h minimum. Servir avec un coulis de fruits rouges.", 'duree' => 90, 'difficulte' => Difficulte::Moyen, 'portions' => 10, 'categorie' => 'entremets', 'image' => 'cheesecake.png', 'produit' => 'Cheesecake'],
            ['titre' => 'Brownies au chocolat',     'slug' => 'brownies-au-chocolat',    'description' => 'Moelleux au cœur fondant, pépites de chocolat noir intense.', 'contenu' => "Préchauffer le four à 180 °C et beurrer un moule carré de 20 × 20 cm.\nFaire fondre 200 g de chocolat noir 70 % avec 150 g de beurre au bain-marie. Laisser tiédir.\nFouetter 3 œufs avec 200 g de sucre jusqu'à léger blanchiment.\nVerser le chocolat fondu sur les œufs sucrés, ajouter 80 g de farine tamisée et une pincée de sel.\nAjouter 100 g de pépites de chocolat, mélanger et verser dans le moule.\nCuire 20 à 22 min — le centre doit être encore légèrement tremblant pour un cœur fondant. Laisser refroidir complètement avant de découper.", 'duree' => 35, 'difficulte' => Difficulte::Facile, 'portions' => 12, 'categorie' => 'petits-fours', 'image' => 'brownies.png', 'produit' => 'Brownies'],
            ['titre' => 'Cookies aux pépites',      'slug' => 'cookies-aux-pepites',     'description' => 'Croustillants à l\'extérieur, fondants à l\'intérieur, généreux en pépites.', 'contenu' => "Fouetter 150 g de beurre mou avec 100 g de sucre blanc et 80 g de cassonade jusqu'à consistance crémeuse.\nAjouter 1 œuf entier + 1 jaune et 1 c. à café de vanille, mélanger.\nIncorporer 280 g de farine, 1 c. à café de bicarbonate et une pincée de sel tamisés ensemble.\nAjouter 200 g de pépites de chocolat noir et mélanger sans trop travailler la pâte.\nFormer des boules de 50 g, les aplatir légèrement et les disposer espacées sur une plaque.\nRéfrigérer 30 min puis cuire 11 min à 180 °C — les bords doivent être dorés et le centre encore mou. Les cookies se raffermiront en refroidissant.", 'duree' => 30, 'difficulte' => Difficulte::Facile, 'portions' => 16, 'categorie' => 'petits-fours', 'image' => 'cookie.png', 'produit' => 'Cookies'],
            // Recettes standalone (sans produit associé)
            ['titre' => 'Tarte au chocolat',         'slug' => 'tarte-au-chocolat',       'description' => 'Ganache intense sur fond sablé, pour les amateurs de chocolat pur.', 'contenu' => "Préparer une pâte sablée au cacao : sabler 220 g de farine avec 20 g de cacao, 100 g de beurre et 80 g de sucre glace. Lier avec 1 œuf, étaler et cuire à blanc 15 min à 175 °C.\nPorter 25 cl de crème liquide à ébullition, la verser en trois fois sur 250 g de chocolat noir haché et mélanger jusqu'à obtenir une ganache lisse et brillante.\nAjouter 30 g de beurre coupé en dés et émulsionner.\nVerser la ganache tiède sur le fond de tarte refroidi et laisser figer 2 h à température ambiante.\nDécorer d'éclats de fleur de sel et d'un filet de chocolat blanc si désiré.", 'duree' => 50, 'difficulte' => Difficulte::Facile, 'portions' => 8, 'categorie' => 'tartes', 'image' => 'tarte-au-chocolat.jpg', 'produit' => null],
            ['titre' => 'Galette des rois frangipane', 'slug' => 'galette-des-rois',      'description' => 'La galette traditionnelle à la frangipane, croustillante et fondante.', 'contenu' => "Étaler deux disques de pâte feuilletée de 24 cm sur du papier cuisson.\nPréparer la frangipane : fouetter 100 g de beurre pommade avec 100 g de sucre, ajouter 100 g de poudre d'amande, 2 œufs et 20 g de farine.\nÉtaler la frangipane sur le premier disque en laissant 2 cm de bord libre. Glisser la fève.\nHumidifier les bords, poser le second disque et souder en pinçant. Dorer à l'œuf et dessiner des motifs au couteau sans percer.\nRéfrigérer 30 min, puis cuire 30 min à 200 °C jusqu'à coloration dorée et uniforme.", 'duree' => 60, 'difficulte' => Difficulte::Moyen, 'portions' => 8, 'categorie' => 'entremets', 'image' => 'galette-des-rois.webp', 'produit' => null],
            ['titre' => 'Panna cotta vanille',       'slug' => 'panna-cotta-vanille',     'description' => 'Crème italienne soyeuse à la vanille, servie avec un coulis de fruits rouges.', 'contenu' => "Faire tremper 3 feuilles de gélatine dans de l'eau froide pendant 5 min.\nPorter 50 cl de crème liquide entière à frémissement avec 1 gousse de vanille fendue et grattée et 60 g de sucre.\nEssorez la gélatine et la dissoudre dans la crème chaude hors du feu. Retirer la gousse.\nVerser dans 6 verrines et laisser refroidir à température ambiante avant de réfrigérer 4 h minimum.\nPréparer un coulis en mixant 200 g de framboises avec 2 c. à soupe de sucre glace. Passer au tamis.\nServir les panna cotta démoulées sur assiette ou directement en verrine, nappées de coulis.", 'duree' => 20, 'difficulte' => Difficulte::Facile, 'portions' => 6, 'categorie' => 'entremets', 'image' => 'pana-cota.jpg', 'produit' => null],
            ['titre' => 'Clafoutis aux cerises',     'slug' => 'clafoutis-aux-cerises',   'description' => 'Gâteau moelleux aux cerises fraîches, entre le flan et le gâteau.', 'contenu' => "Préchauffer le four à 180 °C et beurrer un plat à gratin de 26 cm.\nLaver et équeuter 500 g de cerises (ne pas les dénoyauter pour plus de saveur). Les disposer dans le plat beurré.\nFouetter 3 œufs avec 100 g de sucre jusqu'à blanchiment. Ajouter 60 g de farine tamisée, une pincée de sel et 1 c. à café de vanille.\nIncorporer 30 cl de lait entier tiède en filet en fouettant, puis 20 cl de crème liquide.\nVerser l'appareil sur les cerises et enfourner 40 min jusqu'à coloration dorée.\nSaupoudrer de sucre glace à la sortie du four. Servir tiède ou à température ambiante.", 'duree' => 55, 'difficulte' => Difficulte::Facile, 'portions' => 8, 'categorie' => 'entremets', 'image' => 'clafoutis.jpg', 'produit' => null],
        ];

        foreach ($recettesSupp as $data) {
            $recette = new Recette();
            $recette->setTitre($data['titre']);
            $recette->setSlug($data['slug']);
            $recette->setDescription($data['description']);
            $recette->setContenu($data['contenu']);
            $recette->setDuree($data['duree']);
            $recette->setDifficulte($data['difficulte']);
            $recette->setPortions($data['portions']);
            $recette->setImageName($data['image']);
            $recette->setIsPublished(true);
            if (isset($categories[$data['categorie']])) {
                $recette->setCategorie($categories[$data['categorie']]);
            }
            if ($data['produit'] && isset($produitEntites[$data['produit']])) {
                $recette->setProduit($produitEntites[$data['produit']]);
            }
            $manager->persist($recette);
        }

        foreach ($recettes as $data) {
            $recette = new Recette();
            $recette->setTitre($data['titre']);
            $recette->setSlug($data['slug']);
            $recette->setDescription($data['description']);
            $recette->setContenu($data['contenu']);
            $recette->setDuree($data['duree']);
            $recette->setDifficulte($data['difficulte']);
            $recette->setPortions($data['portions']);
            $recette->setImageName($data['image']);
            $recette->setIsPublished(true);
            if (isset($categories[$data['categorie']])) {
                $recette->setCategorie($categories[$data['categorie']]);
            }
            if ($data['produit'] && isset($produitEntites[$data['produit']])) {
                $recette->setProduit($produitEntites[$data['produit']]);
            }
            $manager->persist($recette);
        }
        // --- Utilisateur de test ---
        $user = new Utilisateur();
        $user->setEmail('test@test.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password123'));
        $user->setIsVerified(true);
        $manager->persist($user);

        $admin = new Utilisateur();
        $admin->setEmail('samy@admin.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'password123'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $manager->persist($admin);

        // Envoie toutes les données en base en une seule fois
        $manager->flush();
    }
}
