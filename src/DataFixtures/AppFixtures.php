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
            'petits-fours' => 'Petits fours',
            'entremets'    => 'Entremets',
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
            ['nom' => 'Tarte aux fraises',        'slug' => 'tarte-aux-fraises',        'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?w=600&q=80', 'description' => 'Tarte fraîche garnie de fraises de saison sur crème pâtissière vanille.'],
            ['nom' => 'Tarte au citron meringuée', 'slug' => 'tarte-citron-meringuee',   'prix' => '7.00', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1765992314341-48ba688f8d49?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dGFydGUlMjBtZXJpbmd1JUMzJUE5ZXxlbnwwfHwwfHx8MA%3D%3D', 'description' => 'Tarte acidulée avec une meringue légère et croustillante.'],
            ['nom' => 'Tarte aux framboises',      'slug' => 'tarte-aux-framboises',     'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=600&q=80', 'description' => 'Fond de tarte croustillant, crème d\'amandes et framboises fraîches.'],
            ['nom' => 'Tarte tatin',               'slug' => 'tarte-tatin',              'prix' => '6.00', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1621955964441-c173e01c135b?w=600&q=80', 'description' => 'Tarte renversée aux pommes caramélisées, servie tiède avec crème fraîche.'],
            ['nom' => 'Tarte aux myrtilles',       'slug' => 'tarte-aux-myrtilles',      'prix' => '6.50', 'categorie' => 'tartes',       'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=600&q=80', 'description' => 'Fond sablé, crème d\'amandes et myrtilles fraîches du marché.'],
            // Choux
            ['nom' => 'Éclair au chocolat',        'slug' => 'eclair-au-chocolat',       'prix' => '4.00', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=600&q=80', 'description' => 'Pâte à choux garnie d\'une crème pâtissière au chocolat noir.'],
            ['nom' => 'Paris-Brest',               'slug' => 'paris-brest',              'prix' => '5.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1631978931011-a033b99bce1e?w=600&q=80', 'description' => 'Couronne de pâte à choux garnie d\'une crème mousseline praliné.'],
            ['nom' => 'Religieuse café',           'slug' => 'religieuse-cafe',          'prix' => '4.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1517244683847-7456b63c5969?w=600&q=80', 'description' => 'Double chou à la crème café, glaçage fondant.'],
            ['nom' => 'Chouquettes (x10)',         'slug' => 'chouquettes-x10',          'prix' => '3.50', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1550617931-e17a7b70dce2?w=600&q=80', 'description' => 'Petits choux légers parsemés de sucre perlé, à croquer sans modération.'],
            ['nom' => 'Saint-Honoré',              'slug' => 'saint-honore',             'prix' => '8.00', 'categorie' => 'choux',        'image' => 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=600&q=80', 'description' => 'Couronne de pâte feuilletée, choux caramélisés et crème Chiboust.'],
            // Petits fours
            ['nom' => 'Macarons (x6)',             'slug' => 'macarons-x6',              'prix' => '9.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?w=600&q=80', 'description' => 'Assortiment de 6 macarons aux parfums variés.'],
            ['nom' => 'Crème brûlée',              'slug' => 'creme-brulee',             'prix' => '5.50', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=600&q=80', 'description' => 'Crème vanille onctueuse avec une fine croûte de caramel.'],
            ['nom' => 'Mille-feuille',             'slug' => 'mille-feuille',            'prix' => '6.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1608039755401-742074f0548d?w=600&q=80', 'description' => 'Feuilletage croustillant, crème pâtissière vanille et glaçage royal.'],
            ['nom' => 'Financiers (x4)',           'slug' => 'financiers-x4',            'prix' => '4.50', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1519676867240-f03562e64548?w=600&q=80', 'description' => 'Petits gâteaux moelleux au beurre noisette et poudre d\'amande.'],
            ['nom' => 'Madeleine au beurre (x6)',  'slug' => 'madeleine-au-beurre-x6',   'prix' => '5.00', 'categorie' => 'petits-fours', 'image' => 'https://images.unsplash.com/photo-1631978931011-a033b99bce1e?w=600&q=80', 'description' => 'Les vraies madeleines de Commercy, moelleuses avec leur bosse caractéristique.'],
            // Entremets
            ['nom' => 'Mousse au chocolat',        'slug' => 'mousse-au-chocolat',       'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=600&q=80', 'description' => 'Mousse aérienne au chocolat noir, à préparer la veille pour un résultat optimal.'],
            ['nom' => 'Charlotte aux framboises',  'slug' => 'charlotte-aux-framboises',  'prix' => '7.50', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&q=80', 'description' => 'Biscuits à la cuillère et mousse framboise, élégante et fraîche.'],
            ['nom' => 'Fondant au chocolat',       'slug' => 'fondant-au-chocolat',      'prix' => '5.50', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&q=80', 'description' => 'Fondant au cœur coulant, à servir tiède avec une boule de glace vanille.'],
            ['nom' => 'Tiramisu',                  'slug' => 'tiramisu',                 'prix' => '5.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=600&q=80', 'description' => 'Mascarpone, biscuits imbibés de café et cacao — un classique italien.'],
            ['nom' => 'Opéra',                     'slug' => 'opera',                    'prix' => '7.00', 'categorie' => 'entremets',    'image' => 'https://images.unsplash.com/photo-1534432182912-63863115e106?w=600&q=80', 'description' => 'Biscuit joconde, crème au beurre café et ganache chocolat en couches alternées.'],
        ];

        $produitEntites = [];
        foreach ($produits as $data) {
            $produit = new Produit();
            $produit->setNom($data['nom']);
            $produit->setSlug($data['slug']);
            $produit->setPrix($data['prix']);
            $produit->setDescription($data['description']);
            $produit->setImageSrc($data['image']);
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
                'image'      => 'https://images.unsplash.com/photo-1519915028121-7d3463d5b1ff?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?w=600&q=80',
                'produit'    => null,
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
                'image'      => 'https://images.unsplash.com/photo-1464305795204-6f5bbfc7fb81?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1631978931011-a033b99bce1e?w=600&q=80',
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
                'image'      => 'https://images.unsplash.com/photo-1608039755401-742074f0548d?w=600&q=80',
                'produit'    => 'Mille-feuille',
            ],
        ];

        foreach ($recettes as $data) {
            $recette = new Recette();
            $recette->setTitre($data['titre']);
            $recette->setSlug($data['slug']);
            $recette->setDescription($data['description']);
            $recette->setContenu($data['contenu']);
            $recette->setDuree($data['duree']);
            $recette->setDifficulte($data['difficulte']);
            $recette->setPortions($data['portions']);
            $recette->setImageSrc($data['image']);
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
